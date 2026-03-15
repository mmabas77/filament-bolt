<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tenant-level migrations for filament-bolt.
 *
 * In a stancl/tenancy database-per-tenant setup, bolt tables live in each
 * tenant's own database. This migration is auto-registered by BoltServiceProvider
 * when `zeus-bolt.tenant_aware` is true, so `php artisan tenants:migrate`
 * creates these tables in every tenant database automatically.
 *
 * Uses `Schema::hasTable()` guards so the migration is idempotent — safe to
 * run on tenants that already have bolt tables from a previous setup.
 */
return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('zeus-bolt.table-prefix', 'bolt_');

        if (! Schema::hasTable($prefix . 'categories')) {
            Schema::create($prefix . 'categories', function (Blueprint $table) {
                $table->id();
                $table->text('name');
                $table->integer('ordering')->default(1);
                $table->boolean('is_active')->default(1);
                $table->text('description')->nullable();
                $table->string('slug');
                $table->string('logo')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable($prefix . 'collections')) {
            Schema::create($prefix . 'collections', function (Blueprint $table) {
                $table->id();
                $table->text('name');
                $table->longText('values')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable($prefix . 'forms')) {
            Schema::create($prefix . 'forms', function (Blueprint $table) use ($prefix) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('category_id')->nullable()->constrained($prefix . 'categories')->nullOnDelete();
                $table->text('name');
                $table->text('description')->nullable();
                $table->string('slug');
                $table->integer('ordering')->default(1);
                $table->boolean('is_active');
                $table->longText('details')->nullable();
                $table->longText('options')->nullable();
                $table->dateTime('start_date')->nullable();
                $table->dateTime('end_date')->nullable();
                $table->text('extensions')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable($prefix . 'sections')) {
            Schema::create($prefix . 'sections', function (Blueprint $table) use ($prefix) {
                $table->id();
                $table->foreignId('form_id')->constrained($prefix . 'forms')->cascadeOnDelete();
                $table->text('name')->nullable();
                $table->integer('ordering')->default(1);
                $table->integer('columns')->default(1);
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->boolean('aside')->default(0);
                $table->boolean('borderless')->default(0);
                $table->boolean('compact')->default(0);
                $table->text('options')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable($prefix . 'fields')) {
            Schema::create($prefix . 'fields', function (Blueprint $table) use ($prefix) {
                $table->id();
                $table->foreignId('section_id')->constrained($prefix . 'sections')->cascadeOnDelete();
                $table->text('name');
                $table->text('description')->nullable();
                $table->string('type');
                $table->integer('ordering')->default(1);
                $table->text('options')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable($prefix . 'responses')) {
            Schema::create($prefix . 'responses', function (Blueprint $table) use ($prefix) {
                $table->id();
                $table->foreignId('form_id')->constrained($prefix . 'forms')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('status')->default('NEW');
                $table->text('notes')->nullable();
                $table->integer('extension_item_id')->nullable();
                $table->integer('grades')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable($prefix . 'field_responses')) {
            Schema::create($prefix . 'field_responses', function (Blueprint $table) use ($prefix) {
                $table->id();
                $table->foreignId('form_id')->constrained($prefix . 'forms')->cascadeOnDelete();
                $table->foreignId('field_id')->constrained($prefix . 'fields')->cascadeOnDelete();
                $table->foreignId('response_id')->constrained($prefix . 'responses')->cascadeOnDelete();
                $table->longText('response');
                $table->integer('grade')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Pro: field presets table
        if (! Schema::hasTable($prefix . 'field_presets')) {
            Schema::create($prefix . 'field_presets', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->longText('preset_data')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        $prefix = config('zeus-bolt.table-prefix', 'bolt_');

        Schema::dropIfExists($prefix . 'field_presets');
        Schema::dropIfExists($prefix . 'field_responses');
        Schema::dropIfExists($prefix . 'responses');
        Schema::dropIfExists($prefix . 'fields');
        Schema::dropIfExists($prefix . 'sections');
        Schema::dropIfExists($prefix . 'forms');
        Schema::dropIfExists($prefix . 'collections');
        Schema::dropIfExists($prefix . 'categories');
    }
};
