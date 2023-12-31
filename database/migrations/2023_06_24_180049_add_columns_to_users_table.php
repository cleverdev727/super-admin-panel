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
    if(!Schema::hasColumn('users', 'role_id')) {
      Schema::table('users', function (Blueprint $table) {
        $table->foreignId('role_id')->constrained('user_roles')->after('email');
        $table->tinyInteger('status')->default(1)->after('email');
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    if (Schema::hasColumn('users', 'role_id')) {
      Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role_id');
        $table->dropColumn('status');
      });
    }
  }
};
