<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, add the user_id column as nullable
        if (!Schema::hasColumn('ideas', 'user_id')) {
            Schema::table('ideas', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }

        // Get the first admin user for default assignment
        $adminUserId = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', 'admin')
            ->value('users.id');

        // If no admin user found, get the first user
        if (!$adminUserId) {
            $adminUserId = DB::table('users')->value('id');
        }

        // Update existing records to use the admin user id
        if ($adminUserId) {
            DB::table('ideas')
                ->whereNull('user_id')
                ->update(['user_id' => $adminUserId]);
        }

        // Now add the foreign key constraint
        Schema::table('ideas', function (Blueprint $table) {
            // First make the column NOT NULL since we've populated it
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Add the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
