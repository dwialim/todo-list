<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Categorie::create([
			'name' => 'todo',
		]);
		Categorie::create([
			'name' => 'in_progress',
		]);
		Categorie::create([
			'name' => 'testing',
		]);
		Categorie::create([
			'name' => 'done',
		]);
		Categorie::create([
			'name' => 'pending',
		]);
	}
}
