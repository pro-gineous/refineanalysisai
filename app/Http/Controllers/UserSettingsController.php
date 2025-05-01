<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserSettingsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar la página de configuraciones del usuario
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $teamMembers = TeamMember::where('owner_id', $user->id)->get();
        
        // Verificar que la pestaña solicitada sea válida
        $tab = $request->query('tab', 'profile');
        $validTabs = ['profile', 'security', 'team', 'notifications', 'branding', 'advanced'];
        
        if (!in_array($tab, $validTabs)) {
            $tab = 'profile';
        }
        
        return view('user.settings', compact('user', 'teamMembers', 'tab'));
    }

    /**
     * Actualizar la información del perfil
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'job_title' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_profile_image' => 'nullable|string',
        ]);

        // Guardar nombre, apellido y email
        $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
        $user->email = $validated['email'];
        
        // Guardar first_name y last_name directamente en la base de datos
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        
        // Guardar job_title
        if (isset($validated['job_title'])) {
            $user->job_title = $validated['job_title'];
        }
        
        // Comprobar si se debe eliminar la imagen de perfil
        if (isset($validated['remove_profile_image']) && $validated['remove_profile_image'] == '1') {
            // Eliminar la imagen si existe
            if ($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image))) {
                unlink(storage_path('app/public/' . $user->profile_image));
            }
            $user->profile_image = null;
        }
        // Si no se elimina, procesar la nueva imagen si se ha subido una
        elseif ($request->hasFile('profile_image')) {
            // Eliminar la imagen anterior si existe
            if ($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image))) {
                unlink(storage_path('app/public/' . $user->profile_image));
            }
            
            // Guardar la nueva imagen
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $user->profile_image = $imagePath;
        }
        
        $user->save();

        return redirect()->route('user.settings', ['tab' => 'profile'])->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Subir la imagen de perfil mediante AJAX
     */
    public function uploadProfileImage(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        try {
            // Eliminar la imagen anterior si existe
            if ($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image))) {
                unlink(storage_path('app/public/' . $user->profile_image));
            }
            
            // Guardar la nueva imagen
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $user->profile_image = $imagePath;
            $user->save();
            
            // Devolver la URL de la nueva imagen para actualizar la interfaz
            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully!',
                'imageUrl' => asset('storage/' . $user->profile_image)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar la imagen de perfil del usuario
     */
    public function removeProfileImage()
    {
        $user = Auth::user();
        
        // Verificar si el usuario tiene una imagen de perfil
        if ($user->profile_image) {
            // Eliminar el archivo físico si existe
            $imagePath = storage_path('app/public/' . $user->profile_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            // Eliminar la referencia en la base de datos
            $user->profile_image = null;
            $user->save();
            
            return redirect()->route('user.settings', ['tab' => 'profile'])->with('success', 'Profile image removed successfully!');
        }
        
        return redirect()->route('user.settings', ['tab' => 'profile'])->with('info', 'No profile image to remove.');
    }

    /**
     * Actualizar la contraseña
     */
    public function updatePassword(Request $request)
    {
        // Validación de la solicitud
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|different:current_password|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $user = Auth::user();
        
        // Verificar que la contraseña actual sea correcta
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'La contraseña actual no es correcta.'])
                ->withInput();
        }
        
        // Actualizar la contraseña
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('user.settings', ['tab' => 'security'])->with('success', 'Password updated successfully!');
    }

    /**
     * Actualizar las preferencias de notificación
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $user->notification_preferences = json_encode([
            'email_notifications' => $request->has('email_notifications'),
            'project_updates' => $request->has('project_updates'),
            'idea_feedback' => $request->has('idea_feedback'),
            'system_updates' => $request->has('system_updates'),
        ]);
        
        $user->save();

        return redirect()->route('user.settings')->with('success', 'Notification preferences updated!');
    }

    /**
     * Actualizar las preferencias de apariencia
     */
    public function updateAppearance(Request $request)
    {
        $user = Auth::user();
        
        $user->appearance_preferences = json_encode([
            'dark_mode' => $request->has('dark_mode'),
            'compact_view' => $request->has('compact_view'),
            'show_tooltips' => $request->has('show_tooltips'),
        ]);
        
        $user->save();

        return redirect()->route('user.settings', ['tab' => 'appearance'])->with('success', 'Appearance preferences updated!');
    }
    
    /**
     * Actualizar configuraciones de seguridad de la cuenta
     */
    public function updateSecurity(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'two_factor_enabled' => 'sometimes|boolean',
            'login_notification' => 'sometimes|boolean',
            'session_timeout' => 'sometimes|integer|min:5|max:1440',
        ]);
        
        $user->security_settings = json_encode([
            'two_factor_enabled' => $request->has('two_factor_enabled'),
            'login_notification' => $request->has('login_notification'),
            'session_timeout' => $request->input('session_timeout', 60),
            'last_password_change' => now()->toDateTimeString(),
        ]);
        
        $user->save();
        
        return redirect()->route('user.settings', ['tab' => 'security'])->with('success', 'Security settings updated successfully!');
    }
    
    /**
     * Añadir un nuevo miembro al equipo
     */
    public function addTeamMember(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:owner,admin,manager,developer,analyst,member,client,viewer',
            'permissions' => 'nullable|array',
        ]);
        
        // Usar el email proporcionado o generar uno si está vacío
        if (!empty($validated['email'])) {
            $email = $validated['email'];
            
            // Verificar si el email ya existe en el equipo
            $existingMember = TeamMember::where('owner_id', Auth::id())
                                       ->where('email', $email)
                                       ->first();
            
            if ($existingMember) {
                return redirect()->route('user.settings', ['tab' => 'team'])
                                ->withErrors(['email' => 'Este correo electrónico ya está registrado en tu equipo.'])
                                ->withInput();
            }
        } else {
            // Generar un correo electrónico único basado en el nombre
            $email = strtolower(str_replace(' ', '.', $validated['name'])) . '@' . config('app.domain', 'company.com');
        }
        
        // Usar el rol proporcionado o asignar el predeterminado
        $role = $validated['role'] ?? 'member';
        
        // Asignar permisos predeterminados según el rol seleccionado o usar los permisos seleccionados manualmente
        if ($request->has('permissions')) {
            $permissions = $request->input('permissions');
        } else {
            // Permisos predeterminados según el rol
            switch ($role) {
                case 'owner':
                case 'admin':
                    $permissions = ['dashboard_view', 'analytics_view', 'reports_export', 'projects_view', 'projects_create', 
                                   'projects_edit', 'projects_delete', 'team_manage', 'settings_edit', 'billing_manage'];
                    break;
                case 'manager':
                    $permissions = ['dashboard_view', 'analytics_view', 'reports_export', 'projects_view', 'projects_create', 
                                   'projects_edit', 'team_manage'];
                    break;
                case 'developer':
                    $permissions = ['dashboard_view', 'analytics_view', 'projects_view', 'projects_create', 
                                   'projects_edit'];
                    break;
                case 'analyst':
                    $permissions = ['dashboard_view', 'analytics_view', 'reports_export', 'projects_view'];
                    break;
                case 'client':
                    $permissions = ['dashboard_view', 'projects_view'];
                    break;
                case 'viewer':
                    $permissions = ['dashboard_view', 'projects_view'];
                    break;
                case 'member':
                default:
                    $permissions = ['dashboard_view', 'analytics_view', 'projects_view', 'projects_edit'];
                    break;
            }
        }
        
        // Crear el nuevo miembro del equipo
        $teamMember = TeamMember::create([
            'owner_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $email,
            'role' => $role,
            'job_title' => $validated['job_title'] ?? null,
            'permissions' => json_encode($permissions),
            'invitation_token' => Str::random(32),
            'invitation_sent_at' => now(),
            'invitation_accepted' => false,
        ]);
        
        // Aquí se podría enviar un email de invitación
        // Mail::to($email)->send(new TeamInvitation($teamMember));
        
        return redirect()->route('user.settings', ['tab' => 'team'])->with('success', 'Team member added successfully!');
    }
    
    /**
     * Eliminar un miembro del equipo
     */
    public function removeTeamMember($id)
    {
        $teamMember = TeamMember::where('id', $id)
                                ->where('owner_id', Auth::id())
                                ->firstOrFail();
        
        $teamMember->delete();
        
        return redirect()->route('user.settings', ['tab' => 'team'])->with('success', 'Team member removed successfully!');
    }
    
    /**
     * Display the branding settings page
     */
    public function branding()
    {
        $user = Auth::user();
        return view('user.branding', compact('user'));
    }

    /**
     * Update branding settings
     */
    public function updateBranding(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Get existing branding settings or create default
        $brandingSettings = $user->branding_settings ? json_decode($user->branding_settings, true) : [];
        
        // Update with new values
        $brandingSettings['company_name'] = $validated['company_name'] ?? '';
        $brandingSettings['website'] = $validated['website'] ?? '';
        $brandingSettings['address'] = $validated['address'] ?? '';
        $brandingSettings['last_updated'] = now()->toDateTimeString();
        
        // Handle logo upload if present
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if (!empty($brandingSettings['logo_path']) && file_exists(storage_path('app/public/' . $brandingSettings['logo_path']))) {
                unlink(storage_path('app/public/' . $brandingSettings['logo_path']));
            }
            
            // Store new logo
            $logoPath = $request->file('company_logo')->store('company-logos', 'public');
            $brandingSettings['logo_path'] = $logoPath;
        }
        
        // Save updated settings
        $user->branding_settings = json_encode($brandingSettings);
        $user->save();
        
        return redirect()->route('user.settings', ['tab' => 'branding'])->with('success', 'Branding settings updated successfully!');
    }
    
    /**
     * Reset branding settings by clearing all fields and removing the logo
     */
    public function resetBranding()
    {
        $user = Auth::user();
        
        // Empty branding settings
        $emptySettings = [
            'company_name' => '',
            'website' => '',
            'address' => '',
            'last_updated' => now()->toDateTimeString()
        ];
        
        // Get existing settings to check if we need to delete a logo
        $existingSettings = $user->branding_settings ? json_decode($user->branding_settings, true) : [];
        
        // Delete logo if it exists
        if (!empty($existingSettings['logo_path']) && file_exists(storage_path('app/public/' . $existingSettings['logo_path']))) {
            unlink(storage_path('app/public/' . $existingSettings['logo_path']));
        }
        
        // Save empty settings
        $user->branding_settings = json_encode($emptySettings);
        $user->save();
        
        return redirect()->route('user.settings', ['tab' => 'branding'])->with('success', 'All branding settings have been successfully cleared.');
    }
    
    /**
     * Update advanced settings
     */
    public function updateAdvanced(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'export_data' => 'required|boolean',
            'timezone' => 'required|string|max:100',
            'date_format' => 'required|string|max:20',
        ]);
        
        // Create settings array
        $settings = [
            'export_data' => (bool) $validated['export_data'],
            'timezone' => $validated['timezone'],
            'date_format' => $validated['date_format'],
            'last_updated' => now()->toDateTimeString(),
        ];
        
        // Direct DB update to bypass any casting issues
        $result = \DB::table('users')
            ->where('id', $user->id)
            ->update([
                'advanced_settings' => json_encode($settings),
                'updated_at' => now()
            ]);
            
        // Refresh user model
        $user->refresh();
        
        // Log for debugging
        \Log::info('Advanced settings update', [
            'user_id' => $user->id,
            'timezone' => $validated['timezone'],
            'date_format' => $validated['date_format'],
            'export_data' => $request->has('export_data'),
            'save_result' => $result
        ]);
        
        // Add debug information as flash data
        $debug = [
            'user_id' => $user->id,
            'timezone_sent' => $validated['timezone'],
            'date_format_sent' => $validated['date_format'],
            'save_result' => $result ? 'true' : 'false',
            'settings_json' => $user->advanced_settings,
            'advanced_settings_before' => $user->getOriginal('advanced_settings')
        ];
        
        if ($result) {
            return redirect()->route('user.settings', ['tab' => 'advanced'])
                ->with('success', 'Advanced settings updated successfully!')
                ->with('debug', $debug);
        } else {
            return redirect()->route('user.settings', ['tab' => 'advanced'])
                ->with('error', 'Failed to save settings. Please try again.')
                ->with('debug', $debug);
        }
    }
}
