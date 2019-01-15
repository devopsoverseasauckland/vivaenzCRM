<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;

use DB;

trait TCity {

    public function getCountryCitiesPaginate($countryId, $currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $data = DB::table('pais')
        ->join('ciudad', 'pais.pais_id', '=', 'ciudad.pais_id')
        ->select('ciudad.ciudad_id', 'ciudad.nombre', 'ciudad.activo', 'pais.pais_id')
        ->where('pais.pais_id', '=', $countryId)
        ->orderBy('ciudad.nombre','asc')
        ->paginate(7);

        $output = '';
        foreach($data as $row)
        {
            $output .= '<tr id="trCity' . $row->ciudad_id . '" >
                            <td>'. $row->ciudad_id . '</td>
                            <td>'. $row->nombre .'</td>
                            <td>
                                <form action="' . route('city.destroy', ['id' => $row->ciudad_id]) . '" method="post">
                                    <input id="countryId" name="countryId" type="hidden" value="' . $row->pais_id . '">
                                 ' . csrf_field();

                                    if( $row->activo == 1 )
                                    {
                                        $output .= '<input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-outline-success btn-sm" type="submit">Activo</button>';
                                    }
                                    else
                                    {
                                        $output .= '<input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Inactivo</button>';
                                    }   
            $output .=      '   </form>
                            </td>
                            <td>
                                <a href="' . route('city.edit', ['id' => $row->ciudad_id]) . '?page=' . $currentPage . '" class="btn btn-outline-primary btn-sm">
                                    Modificar
                                </a>
                            </td>
                            <td>
                                
                            </td>
                        </tr>';
        }

        /* Pagination */
        // if (count($data) > 0)
        // {
        //     $output .= '<ul class="pagination" role="navigation">';

        //     if ($currentPage == '' || $currentPage == 1)
        //     {
        //         $output .= '<li class="page-item disabled" aria-disabled="true" aria-label="« Previous"><span class="page-link" aria-hidden="true">‹</span></li>';
        //         $output .= '<li class="page-item active" aria-current="page" ><span class="page-link">1</span></li>';
        //     } else
        //     {
        //         $output .= '<ul class="pagination" role="navigation">
        //         <li class="page-item" ><a class="page-link" href="#" data-pg-id="1" rel="next" aria-label="« Previous">‹</a></li>';
        //         $output .= '<li class="page-item" ><a class="page-link" data-pg-id="1" href="#">1</a></li>';
        //     }

        //     for($i=1; $i <$data->lastPage(); $i++)
        //     {
        //         if ($currentPage == ($i+1))
        //         {
        //             $output .= '<li class="page-item active" aria-current="page" ><span class="page-link">' . ($i+1) . '</span></li>';
        //         } else
        //         {
        //             $output .= '<li class="page-item"><a class="page-link" data-pg-id="' . ($i+1) . '" href="#">' . ($i+1) . '</a></li>';
        //         }
        //     }

        //     if ($currentPage == $data->lastPage())
        //     {
        //         $output .= '<li class="page-item disabled" aria-disabled="true" >
        //                 <a class="page-link" href="#" rel="next" aria-label="Next »">›</a>
        //                 </li>';
        //         // $output .= '<span>' . $currentPage . '</span>';
        //     } else {
        //         $output .= '<li class="page-item">
        //         <a class="page-link" href="#" data-pg-id="' . $data->lastPage() . '" rel="next" aria-label="Next »">›</a>
        //         </li>';
        //     }
        //     $output .= '</ul>';
        // }
        /* end of pagination */

        return $output;
    }

    public function getPagination($countryId, $currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $data = DB::table('pais')
        ->join('ciudad', 'pais.pais_id', '=', 'ciudad.pais_id')
        ->select('ciudad.ciudad_id', 'ciudad.nombre', 'ciudad.activo', 'pais.pais_id')
        ->where('pais.pais_id', '=', $countryId)
        ->orderBy('ciudad.nombre','asc')
        ->paginate(7);

        $output = '';        

        /* Pagination */
        if (count($data) > 0)
        {
            $output .= '<ul class="pagination" role="navigation">';

            if ($currentPage == '' || $currentPage == 1)
            {
                $output .= '<li class="page-item disabled" aria-disabled="true" aria-label="« Previous"><span class="page-link" aria-hidden="true">‹</span></li>';
                $output .= '<li class="page-item active" aria-current="page" ><span class="page-link">1</span></li>';
            } else
            {
                $output .= '<ul class="pagination" role="navigation">
                <li class="page-item" ><a class="page-link" href="#" data-pg-id="1" rel="next" aria-label="« Previous">‹</a></li>';
                $output .= '<li class="page-item" ><a class="page-link" data-pg-id="1" href="#">1</a></li>';
            }

            for($i=1; $i <$data->lastPage(); $i++)
            {
                if ($currentPage == ($i+1))
                {
                    $output .= '<li class="page-item active" aria-current="page" ><span class="page-link">' . ($i+1) . '</span></li>';
                } else
                {
                    $output .= '<li class="page-item"><a class="page-link" data-pg-id="' . ($i+1) . '" href="#">' . ($i+1) . '</a></li>';
                }
            }

            if ($currentPage == $data->lastPage())
            {
                $output .= '<li class="page-item disabled" aria-disabled="true" >
                        <a class="page-link" href="#" rel="next" aria-label="Next »">›</a>
                        </li>';
                // $output .= '<span>' . $currentPage . '</span>';
            } else {
                $output .= '<li class="page-item">
                <a class="page-link" href="#" data-pg-id="' . $data->lastPage() . '" rel="next" aria-label="Next »">›</a>
                </li>';
            }
            $output .= '</ul>';
        }
        /* end of pagination */

        return $output;
    }

    public function getCountryCities($countryId)
    {
        $citiesCountry = DB::table('pais')
        ->join('ciudad', 'pais.pais_id', '=', 'ciudad.pais_id')
        ->select('ciudad.ciudad_id', 'ciudad.nombre')
        ->where('pais.pais_id', '=', $countryId)
        ->where('ciudad.activo', '=', '1')
        ->orderBy('ciudad.nombre','asc')
        ->get();

        return $citiesCountry;
    }

}