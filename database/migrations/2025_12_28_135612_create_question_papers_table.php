<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('question_papers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('program_id');
            $table->integer('semester');
            $table->string('file_path')
                ->nullable()
                ->default(null);
            $table->string('file_url')
                ->nullable()
                ->default(null);
            $table->year('year');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->onDelete('cascade');
            $table->foreign('university_id')
                ->references('id')
                ->on('universities')
                ->onDelete('cascade');
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_papers');
    }
};
