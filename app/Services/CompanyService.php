<?php

namespace App\Services;

use App\Jobs\CompanyCreated;
use App\Models\Company;

class CompanyService
{

    protected $repository;

    public function __construct(Company $company)
    {
        $this->repository = $company;
    }
    public static function getCompanies(string $filter = "")
    {
        $companies = Company::with('category')
                                ->where(function ($query) use ($filter) {
                                    if (!empty($filter)) {
                                        $query->where('name', 'like', "%{$filter}%");
                                        $query->orWhere('email', '=', $filter);
                                        $query->orWhere('phone', '=', $filter);
                                    }
                                })
                                ->paginate();
        return $companies;
    }

    public static function store($request)
    {
        $company = Company::create($request->validated());
        self::dispatchEmailCompany($company);
        return $company;
    }

    private static function dispatchEmailCompany($company)
    {
        CompanyCreated::dispatch($company);
    }
}
