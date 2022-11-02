<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            $branches = [
                ['id' => 1, 'name' => 'Branch A', 'HOId' => null],
                ['id' => 2, 'name' => 'Branch B', 'HOId' => null],
                ['id' => 3, 'name' => 'Branch C', 'HOId' => null],
                ['id' => 4, 'name' => 'Branch D', 'HOId' => null],
                ['id' => 5, 'name' => 'Branch E', 'HOId' => null],
                ['id' => 6, 'name' => 'Branch F', 'HOId' => null],
                ['id' => 7, 'name' => 'Branch G', 'HOId' => null],
                ['id' => 8, 'name' => 'Branch H', 'HOId' => null],
                ['id' => 9, 'name' => 'Branch I', 'HOId' => null],
                ['id' => 10, 'name' => 'Branch J', 'HOId' => null],

            ];
            foreach ($branches as $branch) {
                Branch::create($branch);
            }

    }
}
