<?php

namespace App\Services;

use App\Models\Company;

class CompanyService
{

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
}
