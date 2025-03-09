<?php

use Database\Seeders\CartesianPointSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        // raw-запрос, т.к. миграции не поддерживают простое создание поля point
        DB::statement(<<<SQL
            CREATE TABLE cartesian_points (
                id bigserial not null constraint products_pk primary key,
                pos point not null
            );
        SQL);

        // сид ПЕРЕД добавлением индекса для ускорения вставки данных
        $seeder = new CartesianPointSeeder();
        $seeder->run();

        // DB::statement("CREATE INDEX ON cartesian_points USING GIST(pos)");
        // gist-индекс можно создать стандартными средствами
        Schema::table('cartesian_points', function (Blueprint $table) {
            $table->spatialIndex('pos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cartesian_points');
    }
};
