<?php
namespace App\Services;

use App\Models\MacroPublication;
use App\Models\Publication;
use App\Traits\GlobalWidgets ;

class ReportService{
    use GlobalWidgets ;

    //For Analyst -> page - perPage - keyword +  macro - sector - company  - type
    public function getReports($page, $perPage, $keyword , $analystId , $macro , $sector , $company , $type , $user){
        if(!empty($keyword)){
            $publications  = Publication::with("Company.Macro:id,name")
                ->with("Company.Sector:id,name")
                ->with("Analyst:id")
                ->with("Analyst.User")
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->whereHas('Analyst', function ($query) use ($analystId) {
                    $query->where('analyst_id', $analystId);
                })
                ->paginate($perPage, ['*'], 'page', $page);

            $macroPublications = MacroPublication::with("Macro:id,name")
                ->with("Analyst.User")
                ->with("Analyst:id")
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->whereHas('Analyst', function ($query) use ($analystId) {
                    $query->where('analyst_id', $analystId);
                })
                ->paginate($perPage, ['*'], 'page', $page);

        } else {

            if (empty($type) || $type == "Macro") {
                $macroPublications = MacroPublication::with("Macro:id,name")
                    ->with("Analyst.User")
                    ->with("Analyst:id")
                    ->when(!empty($macro), function ($query) use ($macro) {
                        $query->whereHas('Macro', function ($subQuery) use ($macro) {
                            $subQuery->whereIn('id', $macro);
                        });
                    })
                    ->whereHas('Analyst', function ($query) use ($analystId) {
                        $query->where('analyst_id', $analystId);
                    })
                    ->orderBy('published_at', 'desc')
                    ->paginate($perPage, ['*'], 'page', $page);
            }

            if(empty($type) || $type == "Equity"){

                $publications = Publication::with("Company.Macro:id,name")
                    ->with("Company.Sector:id,name")
                    ->with("Analyst:id")
                    ->with("Analyst.User")
                    ->when(!empty($macro), function ($query) use ($macro) {
                        $query->whereHas('Company.Macro', function ($subQuery) use ($macro) {
                            $subQuery->whereIn('id', $macro);
                        });
                    })
                    ->when(!empty($sector), function ($query) use ($sector) {
                        $query->whereHas('Company.Sector', function ($subQuery) use ($sector) {
                            $subQuery->whereIn('id', $sector);
                        });
                    })
                    ->when(!empty($company), function ($query) use ($company) {

                        $query->whereHas('Company', function ($subQuery) use ($company) {
                            $subQuery->where('company_id', $company);
                        });
                    })

                    ->whereHas('Analyst', function ($query) use ($analystId) {
                        $query->where('analyst_id', $analystId);
                    })
                    ->orderBy('published_at', 'desc')
                    ->paginate($perPage, ['*'], 'page', $page);

            }

        }

        $reports = array_merge($this->publicationWidget($publications , "company" , $user ), $this->publicationWidget($macroPublications , "macro" , $user ));
        usort($reports, function($a, $b) {return strtotime($b['created_at']) - strtotime($a['created_at']);});
        $total_pages = $publications->lastPage();
        if($total_pages < $macroPublications->lastPage()){$total_pages = $macroPublications->lastPage();}


        return ["reports" => $reports , "total_pages" => $total_pages ];


    }





}
