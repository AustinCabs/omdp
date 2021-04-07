<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'creeped12'.'@gmail.com',
            'password' => bcrypt('password'),
            'gender' => 0,
            'role' => '3',
            'remember_token' => str_random(10),
            'api_token' => str_random(20),
            'status' => 1,
            'created_at' => date('Y-m-d H:m:s')
        ]);

         DB::table('users')->insert([
            'name' => 'User User',
            'email' => 'user'.'@user.com',
            'password' => bcrypt('password'),
            'gender' => 0,
            'role' => '0',
            'remember_token' => str_random(10),
            'api_token' => str_random(20),
            'status' => 1,
            'created_at' => date('Y-m-d H:m:s')
        ]);

         DB::table('users')->insert([
            'name' => 'Billing User',
            'email' => 'billing'.'@billing.com',
            'password' => bcrypt('password'),
            'gender' => 0,
            'role' => '1',
            'remember_token' => str_random(10),
            'api_token' => str_random(20),
            'status' => 1,
            'created_at' => date('Y-m-d H:m:s')
        ]);
        #$table->string('name');
        #$table->string('validity_type');
        #$table->string('validity_unit');
        #$table->string('doc_name');
        DB::table('permittypes')->insert([
            'name' => 'Commercial',
            'validity_type' => 'Years',
            'validity_unit' => '1',
            'type' => 1,
            'doc_name' => 'COMMERCIAL.docx'
        ]);
        DB::table('permittypes')->insert([
            'name' => 'Government Gratuitous Permit',
            'validity_type' => 'Years',
            'validity_unit' => '1',
            'type' => 1,
            'doc_name' => "GOV'T GRAT.docx"
        ]);
        DB::table('permittypes')->insert([
            'name' => 'Industrial',
            'validity_type' => 'Years',
            'validity_unit' => '4',
            'type' => 1,
            'doc_name' => 'INDUSTRIAL.docx'
        ]);
        DB::table('permittypes')->insert([
            'name' => 'Mineral Processor',
            'validity_type' => 'Years',
            'validity_unit' => '4',
            'type' => 0,
            'doc_name' => 'MINERAL PROCESSOR.docx'
        ]);
        DB::table('permittypes')->insert([
            'name' => 'Ore Transport Permit',
            'validity_type' => 'Days',
            'validity_unit' => '15',
            'type' => 0,
            'doc_name' => 'ORE TRANSPORT PERMIT.docx'
        ]);
        DB::table('permittypes')->insert([
            'name' => 'Private Gratuitous Permit',
            'validity_type' => 'Days',
            'validity_unit' => '60',
            'type' => 1,
            'doc_name' => 'PRIV. GRAT.docx'
        ]);
        DB::table('permittypes')->insert([
            'name' => 'Small Scale Mining (SSM)',
            'validity_type' => 'Years',
            'validity_unit' => '2',
            'type' => 0,
            'doc_name' => 'SMALL SCALE MINING.docx'
        ]);
        DB::table('permittypes')->insert([
            'name' => 'Special Permit',
            'validity_type' => 'Days',
            'validity_unit' => '60',
            'type' => 1,
            'doc_name' => 'SPECIAL.docx'
        ]);



        #permit checklists for commercial
        DB::table('checklists')->insert([
            'name' => 'Sketch Plan',
            'permittype_id' => '1'
        ]);
        DB::table('checklists')->insert([
            'name' => 'Area Verification Report',
            'permittype_id' => '1'
        ]);
        DB::table('checklists')->insert([
            'name' => 'Clearance From Government Agencies(CMENRO, Brgy. Resolution, DPWH, NIA)',
            'permittype_id' => '1'
        ]);
        DB::table('checklists')->insert([
            'name' => 'Work Plan',
            'permittype_id' => '1'
        ]);
        DB::table('checklists')->insert([
            'name' => 'Initial Environment Examination Report or Environment Impact Assessment From EMB',
            'permittype_id' => '1'
        ]);
        DB::table('checklists')->insert([
            'name' => 'Certification by the Provincial Assessor',
            'permittype_id' => '1'
        ]);
        DB::table('checklists')->insert([
            'name' => 'Proof of financial and technical capabilities',
            'permittype_id' => '1'
        ]);
        DB::table('checklists')->insert([
            'name' => 'Special Power of Attorney',
            'permittype_id' => '1'
        ]);

        DB::table('checklists')->insert([
            'name' => 'Sketch Plan',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'MOA with Land Owner',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'MOA with Association',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'Certification from Barangay',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'Certification from Tribal Council',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'Area status clearance from MGB-DENR',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'Field verificatin report',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'Small scale mining workplan',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'MENRO Certification',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'Business Permit',
            'permittype_id' => '7'
        ]);

        DB::table('checklists')->insert([
            'name' => 'zoning certification',
            'permittype_id' => '7'
        ]);
        #types EG sand and gravel

        DB::table('types')->insert([
            'name' => 'Sand and Gravel'
        ]);
        DB::table('types')->insert([
            'name' => 'Ore'
        ]);
        #billing types
        DB::table('billing_types')->insert([
            'name' => 'Filing Fee',
            'fee' => '1000',
            'permittype_id' => 1
        ]);
        DB::table('billing_types')->insert([
            'name' => 'Permit Fee',
            'fee' => '500',
            'permittype_id' => 1
        ]);
        DB::table('billing_types')->insert([
            'name' => 'Processing Fee',
            'fee' => '300',
            'permittype_id' => 1
        ]);
        DB::table('billing_types')->insert([
            'name' => 'Verification Fee',
            'fee' => '500',
            'permittype_id' => 1
        ]);
        DB::table('billing_types')->insert([
            'name' => 'Environmental Fee',
            'fee' => '50',
            'permittype_id' => 1
        ]);

        #ssm billing

        DB::table('billing_types')->insert([
            'name' => 'Permit Fee',
            'fee' => '3000',
            'permittype_id' => 7
        ]);

        DB::table('billing_types')->insert([
            'name' => 'Fiing fee',
            'fee' => '20',
            'permittype_id' => 7
        ]);

        DB::table('billing_types')->insert([
            'name' => 'Processing Fee',
            'fee' => '20',
            'permittype_id' => 7
        ]);

        DB::table('billing_types')->insert([
            'name' => 'verification Fee',
            'fee' => '3600',
            'permittype_id' => 7
        ]);
    }
}
