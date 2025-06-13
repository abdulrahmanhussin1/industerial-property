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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('property_type_id')->constrained('property_types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title',255);
            $table->integer('land_area');
            $table->enum('hangar_type', ['hangar', 'truss'])->nullable();
            $table->integer('hangar_area')->nullable();
            $table->decimal('hangar_height', 5, 2)->nullable();
            $table->integer('admin_floors')->nullable();
            $table->decimal('electricity_power', 5, 2)->nullable();
            $table->enum('electricity_unit',['kw','mega'])->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('cranes_count')->default(0);
            $table->decimal('price', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
