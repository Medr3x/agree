<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CardService;
use App\Http\Requests\CardRequest;
use App\Http\Requests\AssignCardRequest;
use App\Http\Requests\ReturnCardRequest;
use App\Http\Requests\ReturnAllCardsRequest;
use App\Models\Card;

class CardsController extends Controller
{
    protected $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * @OA\Get(
     *      path="/api/cards",
     *      tags={"Cards"},
     *      summary="Lista Cartas",
     *      description="",
     *      @OA\Parameter(
     *          name="Content-Type",
     *          description="application/json",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Token obtenido al iniciar sesion",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function index(CardRequest $request)
    {
        $filters = (isset($request->filters) && is_array($request->filters)) ? $request->filters : [];
        $cards = Card::filters($filters)->paginate(1);
        return apiResponse($cards, "Cartas listadas correctamente", 'Listado!',200);
    }

    /**
     * @OA\Post(
     *      path="/api/cards",
     *      tags={"Cards"},
     *      summary="Crear Carta",
     *      description="",
     *      @OA\Parameter(
     *          name="Content-Type",
     *          description="application/json",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Token obtenido al iniciar sesion",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", description="Nombre"),
     *              @OA\Property(property="sku_id", type="string", description="Identificador", example="SA0-S002"),
     *              @OA\Property(property="first_edition", type="integer", description="Permite 0 o 1", example="1"),
     *              @OA\Property(property="serial_code", type="integer", description="Codigo de Serie", example="121231212"),
     *              @OA\Property(property="category_code", type="string", description="Debe existir el codigo de cateoria"),
     *              @OA\Property(property="description", type="string", description="Descripcion"),
     *              @OA\Property(property="price", type="float", description="Precio"),
     *              @OA\Property(property="card_creation_date", type="date", description="Fecha de creacion", example="2020-01-27"),
     *              @OA\Property(property="atk", type="integer", description="Ataque"),
     *              @OA\Property(property="def", type="integer", description="Defensa"),
     *              @OA\Property(property="qty_star", type="integer", description="Estrellas"),
     *              @OA\Property(property="image", type="string", description="Base64"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function store(CardRequest $request)
    {
        try{
            $card = $this->cardService->store($request->all(), Card::class);
        }catch(\Exception $ex){
            log_exception($ex, Card::class, 'store');
        }
        return apiResponse($card, "La carta se creo correctamente", 'Creado!',200);
    }

    /**
     * @OA\Get(
     *      path="/api/cards/{id}",
     *      tags={"Cards"},
     *      summary="Mostrar Carta",
     *      description="",
     *      @OA\Parameter(
     *          name="Content-Type",
     *          description="application/json",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Token obtenido al iniciar sesion",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function show(CardRequest $request, Card $card)
    {
        return apiResponse($card, "La carta es mostrada correctamente", 'Mostrado!',200);
    }

    /**
     * @OA\Put(
     *      path="/api/cards/{id}",
     *      tags={"Cards"},
     *      summary="Actualizar Cartas",
     *      description="",
     *      @OA\Parameter(
     *          name="Content-Type",
     *          description="application/json",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Token obtenido al iniciar sesion",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", description="Nombre"),
     *              @OA\Property(property="sku_id", type="string", description="Identificador", example="SA0-S002"),
     *              @OA\Property(property="first_edition", type="integer", description="Permite 0 o 1", example="1"),
     *              @OA\Property(property="serial_code", type="integer", description="Codigo de Serie", example="121231212"),
     *              @OA\Property(property="category_code", type="string", description="Debe existir el codigo de cateoria"),
     *              @OA\Property(property="description", type="string", description="Descripcion"),
     *              @OA\Property(property="price", type="float", description="Precio"),
     *              @OA\Property(property="card_creation_date", type="date", description="Fecha de creacion", example="2020-01-27"),
     *              @OA\Property(property="atk", type="integer", description="Ataque"),
     *              @OA\Property(property="def", type="integer", description="Defensa"),
     *              @OA\Property(property="qty_star", type="integer", description="Estrellas"),
     *              @OA\Property(property="image", type="string", description="Base64"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function update(CardRequest $request, Card $card)
    {
        try{
            $card = $this->cardService->update($request->all(), $card);
        }catch(\Exception $ex){
            log_exception($ex, Card::class, 'update');
        }
        return apiResponse($card, "La carta se modifico correctamente", 'Modificado!',200);
    }

    /**
     * @OA\Delete(
     *      path="/api/cards/{id}",
     *      tags={"Cards"},
     *      summary="Eliminar Cartas",
     *      description="",
     *      @OA\Parameter(
     *          name="Content-Type",
     *          description="application/json",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Token obtenido al iniciar sesion",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function destroy(CardRequest $request, Card $card)
    {
        try{
            $this->cardService->destroy($request, $card);
        }catch(\Exception $ex){
            log_exception($ex, Card::class, 'destroy');
        }
        return apiResponse($card, "La carta se elimino correctamente", 'Eliminado!',200);
    }
    
    /**
     * @OA\Post(
     *      path="/api/cards/assign",
     *      tags={"Cards"},
     *      summary="Asignar Carta",
     *      description="",
     *      @OA\Parameter(
     *          name="Content-Type",
     *          description="application/json",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Token obtenido al iniciar sesion",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="card", type="integer", description="Id de Carta"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function assignCard(AssignCardRequest $request)
    {
        try{
           $card = $this->cardService->assignCard($request);
        }catch(\Exception $ex){
            log_exception($ex, Card::class, 'assignCard');
        }
        return apiResponse($card, "La carta ha sido asignada!", 'Asignada!',200);
    }

    /**
     * @OA\Post(
     *      path="/api/cards/return-card",
     *      tags={"Cards"},
     *      summary="Retornar Carta",
     *      description="",
     *      @OA\Parameter(
     *          name="Content-Type",
     *          description="application/json",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Token obtenido al iniciar sesion",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="card", type="integer", description="Id de Carta"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function returnCard(ReturnCardRequest $request)
    {
        try{
            $card = $this->cardService->returnCard($request);
        }catch(\Exception $ex){
            log_exception($ex, Card::class, 'returnCard');
        }
        return apiResponse($card, "La carta se ha devuelto!", 'Retornada!',200);
    }

    /**
     * @OA\Post(
     *      path="/api/cards/return-all-cards",
     *      tags={"Cards"},
     *      summary="Retornar Carta",
     *      description="",
     *      @OA\Parameter(
     *          name="Content-Type",
     *          description="application/json",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Token obtenido al iniciar sesion",
     *          required=true,
     *          in="header",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function returnAllCards(Request $request)
    {
        try{
            $this->cardService->returnAllCards();
        }catch(\Exception $ex){
            log_exception($ex, Card::class, 'returnAllCards');
        }
        return apiResponse([], "Las cartas se han devuelto!", 'Retornadas!',200);
    }
}
