<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Legacy "users" columns
|--------------------------------------------------------------------------
|
| The ijinnakes authentication flow does not use the stock Laravel users
| table. It authenticates with `username` (see App\Http\Requests\Auth\LoginRequest
| and App\Models\UserModel::GetUser) and stores `last_login`, `no_telepon`,
| `role`, `isActive`, `photo_url`, `class_op`, `foto_not_avail` and
| `saved_photo` (see App\Models\AdminModel).
|
| Every column is added only when it is missing, so this migration is a no-op
| against the existing production MySQL schema (rekomnakes_dev) and only fills
| in the gaps on a fresh database (e.g. the local SQLite setup).
|
*/

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'username' => fn (Blueprint $table) => $table->string('username')->nullable()->index(),
            'last_login' => fn (Blueprint $table) => $table->timestamp('last_login')->nullable(),
            'no_telepon' => fn (Blueprint $table) => $table->string('no_telepon', 30)->nullable(),
            'role' => fn (Blueprint $table) => $table->string('role', 50)->nullable(),
            'isActive' => fn (Blueprint $table) => $table->string('isActive', 5)->nullable()->default('1'),
            'photo_url' => fn (Blueprint $table) => $table->text('photo_url')->nullable(),
            'foto_not_avail' => fn (Blueprint $table) => $table->string('foto_not_avail', 255)->nullable(),
            'saved_photo' => fn (Blueprint $table) => $table->string('saved_photo', 255)->nullable(),
            'class_op' => fn (Blueprint $table) => $table->string('class_op', 50)->nullable(),
        ];

        foreach ($columns as $name => $definition) {
            if (Schema::hasColumn('users', $name)) {
                continue;
            }

            Schema::table('users', function (Blueprint $table) use ($definition) {
                $definition($table);
            });
        }

        // The stock migration makes "email" NOT NULL, but the legacy code
        // creates accounts with only a username (App\Models\AdminModel
        // ::createUserNakes), so the column has to accept NULL.
        foreach (['email', 'name'] as $nullable) {
            if (! Schema::hasColumn('users', $nullable)) {
                continue;
            }

            $isNullable = collect(Schema::getColumns('users'))
                ->firstWhere('name', $nullable)['nullable'] ?? false;

            if (! $isNullable) {
                Schema::table('users', function (Blueprint $table) use ($nullable) {
                    $table->string($nullable)->nullable()->change();
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['class_op', 'saved_photo', 'foto_not_avail', 'photo_url', 'isActive', 'role', 'no_telepon', 'last_login', 'username'] as $name) {
            if (Schema::hasColumn('users', $name)) {
                Schema::table('users', function (Blueprint $table) use ($name) {
                    $table->dropColumn($name);
                });
            }
        }
    }
};