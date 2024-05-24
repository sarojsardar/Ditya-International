<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Schema::disableForeignKeyConstraints();

        //truncate
        DB::table('role_has_permissions')->truncate();
        Permission::truncate();
        Role::truncate();

        //permission list
        $settingPermissions = ['settings-create', 'settings-read', 'settings-update', 'settings-delete'];
        $roleManagementPermissions = ['role-create', 'role-read', 'role-update', 'role-delete'];
        $companyPermissions = ['company-create', 'company-read', 'company-update', 'company-delete'];
        $staffManagementPermissions = ['staff-create', 'staff-read', 'staff-update', 'staff-delete'];
        $companyDemandPermissions = ['demand-create', 'demand-read', 'demand-update', 'demand-delete'];
        $candidateManagementPermissions = ['candidate-create', 'candidate-read', 'candidate-update', 'candidate-delete'];
        $candidateInterviewManagementPermissions = ['interview-approve', 'interview-reject', 'interview-comment', 'interview-read'];
        $documentProcessPermissions = ['document-read', 'document-approve', 'document-reject', 'document-update'];
        $webContentPermissions = ['webContent-create', 'webContent-read', 'webContent-update', 'webContent-delete'];
        $medicalPermissions = ['medical-create', 'medical-read', 'medical-update', 'medical-delete'];
        $pettyCashPermissions = ['pettyCash-request', 'pettyCash-read', 'pettyCash-reject', 'pettyCash-approve'];
        $invoicePermissions = ['invoice-request', 'invoice-read', 'invoice-update', 'invoice-delete'];
        $expensesPermission = ['expense-create', 'expense-delete', 'expense-read', 'expense-statement'];
        $allDemandPermission = ['all-demand-read'];
        $managerCompanyPermissions = ['manager-company-read'];
        $receptionistCompanyPermissions = ['receptionist-company-read'];
        $managerDemandPermissions = ['manager-demand-read'];
        $managerCandidatePermissions = ['manager-candidate-read'];
        //permission merge
        $arrayOfSettingsPermissionNames = array_merge(
            $settingPermissions, $companyPermissions,
            $staffManagementPermissions,
            $companyDemandPermissions,
            $candidateManagementPermissions,
            $roleManagementPermissions,
            $candidateInterviewManagementPermissions,
            $documentProcessPermissions,
            $webContentPermissions,
            $medicalPermissions,
            $pettyCashPermissions,
            $invoicePermissions,
            $expensesPermission,
            $allDemandPermission,
            $managerCompanyPermissions,
            $managerDemandPermissions,
            $managerCandidatePermissions,
            $receptionistCompanyPermissions


        );
        $permissions = collect($arrayOfSettingsPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        //role
        $role = Role::create(['name' => 'CEO']);
        Role::create(['name' => 'HR']);
        $proRole = Role::create(['name' => 'PRO']);
        $company = Role::create(['name' => 'Company']);
        $receptionistRole = Role::create(['name' => 'Receptionist']);
        $documentOfficerRole = Role::create(['name' => 'Document-Officer']);
        $managerRole = Role::create(['name' => 'Manager']);
        $medicalOfficer = Role::create(['name' => 'Medical-Officer']);
        $accountant = Role::create(['name' => 'Accountant']);

        $role->givePermissionTo(Permission::all());

        //manager permissions
        $managerPermissions = array_merge(
            $managerCompanyPermissions,$managerDemandPermissions,
            $managerCandidatePermissions
        );

        $receptionistPermissions = array_merge(
            $receptionistCompanyPermissions
        );


        //accountant permissions
        $accountantPermissions = array_merge(
            $invoicePermissions,
            $expensesPermission,
            ['pettyCash-request', 'pettyCash-read']
        );

        //company permissions
        $companyPermissions = array_merge(
            $companyDemandPermissions,
            $allDemandPermission,
            $candidateManagementPermissions
        );

        $proRole->syncPermissions($candidateManagementPermissions);

        $accountant->syncPermissions($accountantPermissions);

        $receptionistRole->syncPermissions($receptionistPermissions);

        $documentOfficerRole->syncPermissions($documentProcessPermissions);

        $medicalOfficer->syncPermissions($medicalPermissions);

        $managerRole->syncPermissions($managerPermissions);

        $company->syncPermissions($companyPermissions);


        Schema::enableForeignKeyConstraints();

    }
}
