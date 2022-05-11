<?php


namespace App\DataTables;

use App\Export\OrderExport;
use App\Http\Middleware\App;
use Yajra\DataTables\Services\DataTable;

class ServiceDataTable extends DataTable
{

    public function excel()
    {
        $excel = app('excel');
        /*$query = app()->call([$this, 'query']);
        $query = $this->applyScopes($query);

        $dataTable = app()->call([$this, 'dataTable'], compact('query'));
        $dataTable->skipPaging();
        $data_query = $dataTable->getFilteredQuery();

        return new $this->exportClass($data_query);*/
        (new OrderExport)->queue('Order.xlsx');
         return back()->withSuccess('Export started!');
    }
}