<?php
namespace App\Http\Controllers;

use App\Models\CompanyRequest;
use App\Models\Tenant as ModelsTenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyRequestController extends Controller
{
    // Show onboarding form
    public function create()
    {
        return view("CompanyRequests.create");
    }

    // Handle form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain'          => 'required|string|unique:company_requests,domain',
            'company_name'    => 'required|string',
            'contact_address' => 'required|string',
            'contact_email'   => 'required|email|unique:company_requests,contact_email',
            'contact_phone'   => 'nullable|string',
        ]);

        CompanyRequest::create($validated);

        return redirect('/')->with('success', 'Company request submitted!');
    }

    // List all company requests
    public function index()
    {
        $requests = CompanyRequest::paginate(5);
        return Inertia::render('company/requests', [
            'requests' => $requests,
        ]);
    }

    // Show a single company request
    public function show($id)
    {
        $request = CompanyRequest::findOrFail($id);
        return Inertia::render('Company/Requests', [
            'request' => $request,
        ]);
    }

    // Update status (accept, reject, etc.)
    public function update(Request $request, $id)
    {
        $companyRequest = CompanyRequest::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $companyRequest->update($validated);

        // If accepted, create tenant
        if ($validated['status'] === 'accepted') {
            $tenantData = [
                'name'     => $companyRequest->company_name,
                'email'    => $companyRequest->contact_email,
                'password' => bcrypt('hello123'), // Set a default password or generate one
                'domain'   => $companyRequest->domain,
            ];

            $tenant = ModelsTenant::create($tenantData);

            $tenant->domains()->create([
                'domain' => $tenantData['domain'] . '.' . config('app.app_domain'),
            ]);
        }

        return redirect()->back()->with('success', 'Company request updated!');
    }

    // Helper method to create a tenant
    protected function createTenantFromRequest(CompanyRequest $request)
    {
        // Check if tenant already exists
    }
}
