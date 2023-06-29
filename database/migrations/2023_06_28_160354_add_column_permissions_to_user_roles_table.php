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
    if (!Schema::hasColumn('user_roles', 'column_permissions')) {
      Schema::table('user_roles', function (Blueprint $table) {
        $table->longText('column_permissions')->nullable()->after('permissions');
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    if (Schema::hasColumn('user_roles', 'column_permissions')) {
      Schema::table('user_roles', function (Blueprint $table) {
        $table->dropColumn('column_permissions');
      });
    }
  }
};
