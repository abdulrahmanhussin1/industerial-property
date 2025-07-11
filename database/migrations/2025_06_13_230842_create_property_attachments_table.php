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
        Schema::create('property_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade')->onUpdate('cascade');
            $table->string('path', 255);
            $table->string('file_name', 255);
            $table->string('size', 50)->nullable(); // Optional: to store file size
            $table->string('file_type', 50)->nullable(); // Optional: to store file type
            $table->string('file_extension', 10)->nullable(); // Optional: to store file extension
            $table->string('uploaded_by', 50)->nullable(); // Optional: to store the user who uploaded the file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_attachments');
    }
};
