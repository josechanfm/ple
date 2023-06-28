<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberExport implements FromCollection, WithHeadings
{

    public function headings():array
    {
        return ['first name', 'Last Name'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Member::select('first_name','last_name')->whereNotNull('user_id')->get();
    }
}
