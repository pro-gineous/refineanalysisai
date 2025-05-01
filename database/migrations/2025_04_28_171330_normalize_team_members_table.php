<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // إعادة تعريف استخدام جدول team_members بصورة موحدة
        // 1. التحقق من وجود الحقول وإضافة ما هو غير موجود
        // 2. تسمية موحدة: user_id (صاحب الفريق) و team_member_id (العضو المدعو)
        Schema::table('team_members', function (Blueprint $table) {
            // إضافة حقل user_id إذا لم يكن موجودًا
            if (!Schema::hasColumn('team_members', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }

            // إضافة حقل team_member_id إذا لم يكن موجودًا
            if (!Schema::hasColumn('team_members', 'team_member_id')) {
                $table->unsignedBigInteger('team_member_id')->nullable();
                $table->foreign('team_member_id')->references('id')->on('users')->onDelete('cascade');
            }

            // إضافة حقل status إذا لم يكن موجودًا
            if (!Schema::hasColumn('team_members', 'status')) {
                $table->string('status')->default('pending');
            }
            
            // جعل حقل owner_id قابل للقيم الفارغة (nullable) إذا كان موجودًا
            if (Schema::hasColumn('team_members', 'owner_id')) {
                $table->unsignedBigInteger('owner_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // لا نحتاج إلى عكس هذه التغييرات لأنها مجرد تحسينات للهيكل
    }
};
