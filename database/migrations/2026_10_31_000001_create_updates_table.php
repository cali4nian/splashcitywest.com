<?php

use App\Models\Update;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('updates', function (Blueprint $table): void {
            $table->id();
            $table->string('category', 50);
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        $sortOrder = 0;

        if (Schema::hasTable('programs')) {
            $programSelect = ['name', 'subtitle', 'description'];

            if (Schema::hasColumn('programs', 'image_path')) {
                $programSelect[] = 'image_path';
            }

            $programs = DB::table('programs')->select($programSelect)->orderBy('id')->get();

            foreach ($programs as $program) {
                DB::table('updates')->insert([
                    'category' => Update::CATEGORY_PROGRAM,
                    'title' => (string) $program->name,
                    'subtitle' => $program->subtitle !== null ? (string) $program->subtitle : null,
                    'description' => (string) $program->description,
                    'image_path' => property_exists($program, 'image_path') && $program->image_path !== null ? (string) $program->image_path : null,
                    'sort_order' => $sortOrder++,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (Schema::hasTable('site_events')) {
            $eventSelect = ['event_date', 'title', 'details'];

            if (Schema::hasColumn('site_events', 'image_path')) {
                $eventSelect[] = 'image_path';
            }

            $events = DB::table('site_events')->select($eventSelect)->orderBy('id')->get();

            foreach ($events as $event) {
                DB::table('updates')->insert([
                    'category' => Update::CATEGORY_EVENT,
                    'title' => (string) $event->title,
                    'subtitle' => $event->event_date !== null ? (string) $event->event_date : null,
                    'description' => (string) $event->details,
                    'image_path' => property_exists($event, 'image_path') && $event->image_path !== null ? (string) $event->image_path : null,
                    'sort_order' => $sortOrder++,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (Schema::hasTable('success_stories')) {
            $storySelect = ['name', 'title', 'description'];

            if (Schema::hasColumn('success_stories', 'image_path')) {
                $storySelect[] = 'image_path';
            }

            $stories = DB::table('success_stories')->select($storySelect)->orderBy('id')->get();

            foreach ($stories as $story) {
                DB::table('updates')->insert([
                    'category' => Update::CATEGORY_SUCCESS_STORY,
                    'title' => (string) $story->title,
                    'subtitle' => $story->name !== null ? (string) $story->name : null,
                    'description' => (string) $story->description,
                    'image_path' => property_exists($story, 'image_path') && $story->image_path !== null ? (string) $story->image_path : null,
                    'sort_order' => $sortOrder++,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('updates');
    }
};
