<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuportSubject;

class SuportSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SuportSubject::create([
            'subject_en' => 'General Inquiry',
            'subject_ch' => '题问 / 其他',
            'status' => 'Active',
            ],
        );

        SuportSubject::create([
            'subject_en' => 'I would like to inquiry about withdrawal process',
            'subject_ch' => '我想询问有关提款流程程序',
            'status' => 'Active',
        ]);

        SuportSubject::create([
            'subject_en' => 'I would like to inquiry about Fund Management',
            'subject_ch' => '我想询问有关基金管理的问题',
            'status' => 'Active'
        ]);

        SuportSubject::create([
            'subject_en' => 'I would like to inquiry about available packages',
            'subject_ch' => '我想询问有关维利集团的仓位',
            'status' => 'Active'
        ]);

        SuportSubject::create([
            'subject_en' => 'I would like to inquiry about funding or top-up pr...',
            'subject_ch' => '我想询问有关升级配套程序的问题',
            'status' => 'Active'
        ]);

        SuportSubject::create([
            'subject_en' => 'I would like to inquiry about commission',
            'subject_ch' => '我想询问有关佣金的问题',
            'status' => 'Active'
        ]);

        SuportSubject::create([
            'subject_en' => 'I would like to remove unused account',
            'subject_ch' => '我想注销账号',
            'status' => 'Active'
        ]);
    }
}
