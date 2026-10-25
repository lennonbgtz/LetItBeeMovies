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
        Schema::table('movies', function (Blueprint $table) {
               if (! Schema::hasColumn('movies', 'is_reviewed')) {
       $table->boolean('is_reviewed')->default(false);
   }
   if (! Schema::hasColumn('movies', 'trailer_url')) {
       $table->string('trailer_url')->nullable();
   }
   if (! Schema::hasColumn('movies', 'director')) {
       $table->string('director')->nullable();
   }
   if (! Schema::hasColumn('movies', 'runtime')) {
       $table->unsignedSmallInteger('runtime')->nullable();
   }
   if (! Schema::hasColumn('movies', 'cast_members')) {
       $table->text('cast_members')->nullable();
   }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            //
        });
    }
};
