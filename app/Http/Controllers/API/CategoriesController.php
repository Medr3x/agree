<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoriesController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *      path="/api/categories",
     *      tags={"Categories"},
     *      summary="Lista Categorias y SubCategorias",
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
    public function index(CategoryRequest $request)
    {
        try{
            $categories = Category::whereNull('parent_id')->with('childs')->paginate(2);
        }catch(\Exception $ex){
            log_exception($ex, Category::class, 'index');
        }
        return apiResponse($categories, "Tipos listados correctamente", 'Listado!',200);
    }

    /**
     * @OA\Post(
     *      path="/api/categories",
     *      tags={"Categories"},
     *      summary="Crear Categorias y SubCategorias",
     *      description="El parametro parent_code es opcional, si se desea crear una categoria padre no se envia en el body.",
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
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="sku_id", type="string"),
     *              @OA\Property(property="parent_code", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
     */
    public function store(CategoryRequest $request)
    {
        try{
            $category = $this->categoryService->store($request->all(), Category::class);
        }catch(\Exception $ex){
            log_exception($ex, Category::class, 'store');
        }
        return apiResponse($category, "La categoria se creo correctamente", 'Creado!',200);
    }

    /**
     * @OA\Get(
     *      path="/api/categories/{id}",
     *      tags={"Categories"},
     *      summary="Mostrar Categoria y SubCategoria",
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
    public function show(CategoryRequest $request, Category $category)
    {
        return apiResponse($category, "La categoria mostrada correctamente", 'Creado!',200);
    }

    /**
     * @OA\Put(
     *      path="/api/categories/{id}",
     *      tags={"Categories"},
     *      summary="Actualizar Categorias y SubCategorias",
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
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="sku_id", type="string"),
     *              @OA\Property(property="parent_id", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       )
     *  )
    */
    public function update(CategoryRequest $request, Category $category)
    {
        try{
            $category = $this->categoryService->update($request->all(), $category);
        }catch(\Exception $ex){
            log_exception($ex, Category::class, 'update');
        }
        return apiResponse($category, "La categoria se modificado correctamente", 'Modificado!',200);
    }

    /**
     * @OA\Delete(
     *      path="/api/categories/{id}",
     *      tags={"Categories"},
     *      summary="Eliminar Categorias y SubCategorias",
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
    public function destroy(CategoryRequest $request, Category $category)
    {
        try{
            $this->categoryService->destroy($request, $category);
        }catch(\Exception $ex){
            log_exception($ex, Category::class, 'destroy');
        }
        return apiResponse($category, "La categoria se elimino correctamente", 'Eliminado!',200);
    }
}
