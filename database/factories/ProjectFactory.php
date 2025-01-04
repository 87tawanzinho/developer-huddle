<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Storage;
use Illuminate\Http\File;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'cover_path' => $this->createImage(),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    private function createImage(): bool|string
    {
        $path = 'images/projects';
        if(!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        $imageContent = file_get_contents('https://picsum.photos/640/480');
        $tempPath = \Str::random(10) . '.jpg';
        file_put_contents($tempPath, $imageContent);
        $imagePath = Storage::putFileAs($path, new File($tempPath), $tempPath);
        unlink($tempPath);
        return $imagePath;
    }
}
