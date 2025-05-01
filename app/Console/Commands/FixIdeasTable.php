<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class FixIdeasTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fix-ideas-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the ideas table by adding missing user_id column and other structure fixes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!Schema::hasTable('ideas')) {
            $this->error('The ideas table does not exist.');
            return 1;
        }

        $this->info('Checking ideas table structure...');
        
        $hasUserIdColumn = Schema::hasColumn('ideas', 'user_id');
        
        if ($hasUserIdColumn) {
            $this->info('The user_id column already exists in the ideas table.');
        } else {
            $this->info('The user_id column does not exist in the ideas table. Adding it now...');
            
            // Add the user_id column as nullable initially
            Schema::table('ideas', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
            
            $this->info('Added user_id column to ideas table.');
            
            // Get default user ID for assignment (first admin or any user)
            $adminUserId = DB::table('users')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->where('roles.name', 'admin')
                ->value('users.id');
                
            if (!$adminUserId) {
                $adminUserId = DB::table('users')->value('id');
            }
            
            if ($adminUserId) {
                $this->info("Assigning all existing ideas to user ID: {$adminUserId}");
                
                // Update existing records
                $updated = DB::table('ideas')
                    ->whereNull('user_id')
                    ->update(['user_id' => $adminUserId]);
                    
                $this->info("Updated {$updated} idea records with default user ID.");
                
                // Make the column NOT NULL and add foreign key
                if (Schema::hasTable('users')) {
                    try {
                        Schema::table('ideas', function (Blueprint $table) {
                            $table->unsignedBigInteger('user_id')->nullable(false)->change();
                            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                        });
                        $this->info('Added foreign key constraint to user_id column.');
                    } catch (\Exception $e) {
                        $this->error('Could not add foreign key constraint: ' . $e->getMessage());
                    }
                }
            } else {
                $this->error('No users found in the database to assign as default owner for ideas.');
            }
        }

        // Now check the projects table for the same issue
        if (Schema::hasTable('projects') && !Schema::hasColumn('projects', 'user_id')) {
            $this->info('The user_id column does not exist in the projects table. Adding it now...');
            
            Schema::table('projects', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
            
            // Assign the same default user
            if (isset($adminUserId) && $adminUserId) {
                $updated = DB::table('projects')
                    ->whereNull('user_id')
                    ->update(['user_id' => $adminUserId]);
                    
                $this->info("Updated {$updated} project records with default user ID.");
                
                try {
                    Schema::table('projects', function (Blueprint $table) {
                        $table->unsignedBigInteger('user_id')->nullable(false)->change();
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    });
                    $this->info('Added foreign key constraint to projects.user_id column.');
                } catch (\Exception $e) {
                    $this->error('Could not add foreign key constraint to projects table: ' . $e->getMessage());
                }
            }
        }

        $this->info('Database fix completed successfully.');
        return 0;
    }
}
