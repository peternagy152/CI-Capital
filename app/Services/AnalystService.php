<?php
namespace App\Services;
use App\Models\Analyst;

class AnalystService {

    public function getAnalysts($page , $perPage , $keyword , $wishlist , $user , $macro , $sector){
        if(!empty($keyword)){
             return Analyst::with("User")
                ->whereHas('User', function ($query) use ($keyword) {
                    $query->where("name", "like", "%" . $keyword . "%");
                })
                ->paginate($perPage, ['*'], 'page', $page);
        }

        if($wishlist){
            return $user->LikeAnalyst()->with("User")->paginate($perPage, ['*'], 'page', $page);
        }

         return Analyst::with("User")->with("Sector")
            ->when(!empty($sector), function ($query) use ($sector) {
                $query->whereHas('Sector', function ($subQuery) use ($sector) {
                    $subQuery->whereIn('analysts_sectors.sector_id', $sector);
                });
            })
            ->when(!empty($macro), function ($query) use ($macro) {
                $query->whereHas('Macro', function ($subQuery) use ($macro) {
                    $subQuery->whereIn('analysts_macros.macro_id', $macro);
                });
            })
            ->paginate($perPage, ['*'], 'page', $page);

    }

    public function formatAnalyst($analysts , $user){

        $collectedAnalysts = [];
        foreach ($analysts as $oneAnalyst) {
            if($oneAnalyst->id == 26){continue;}
            $sectors = [] ;
            foreach($oneAnalyst['Sector'] as  $oneSector) {$sectors[] = $oneSector->name;}
            $data = [
                "id" => $oneAnalyst->id,
                "liked" => $user->LikeAnalyst()->wherePivot('analyst_id', $oneAnalyst->id)->exists(),
                "profile_pic" => url('/storage') . '/' . $oneAnalyst['user']->profile_pic,
                "name" => $oneAnalyst['user']->name,
                "title" => $oneAnalyst['user']->title,
                "email" => $oneAnalyst['user']->email,
                "sectors" => $sectors ,
            ];

            $collectedAnalysts [] = $data;

        }
        return $collectedAnalysts ;
    }

}
