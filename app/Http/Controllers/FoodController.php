<?php
/**
 * File name: FoodController.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers;

use App\Criteria\Foods\FoodsOfUserCriteria;
use App\DataTables\FoodDataTable;
use App\Http\Requests\CreateFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\ExtraGroup;
use App\Models\Media;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\FoodRepository;
use App\Repositories\UploadRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    /** @var  FoodRepository */
    private $foodRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(FoodRepository $foodRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo
        , RestaurantRepository $restaurantRepo
        , CategoryRepository $categoryRepo)
    {
        parent::__construct();
        $this->foodRepository = $foodRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
        $this->restaurantRepository = $restaurantRepo;
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Food.
     *
     * @param FoodDataTable $foodDataTable
     * @return Response
     */
    public function index(FoodDataTable $foodDataTable)
    {
        return $foodDataTable->render('foods.index');
    }

    /**
     * Show the form for creating a new Food.
     *
     * @return Response
     */
    public function create()
    {

        $category = $this->categoryRepository->pluck('name', 'id');
        if (auth()->user()->hasRole('admin')) {
            $restaurant = $this->restaurantRepository->pluck('name', 'id');
        } else {
            $restaurant = $this->restaurantRepository->myActiveRestaurants()->pluck('name', 'id');
        }
        $hasCustomField = in_array($this->foodRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->foodRepository->model());
            $html = generateCustomField($customFields);
        }

        $extraGroups = ExtraGroup::pluck('name', 'id');
        $extrasSelected = [];
        $extraGroupsSelected = [];

        return view('foods.create')
            ->with("customFields", isset($html) ? $html : false)
            ->with("restaurant", $restaurant)
            ->with("category", $category)
            ->with("extraGroups", $extraGroups)
            ->with("extraGroupsSelected", $extraGroupsSelected)
            ->with("extrasSelected", $extrasSelected);
    }

    /**
     * Store a newly created Food in storage.
     *
     * @param CreateFoodRequest $request
     *
     * @return Response
     */
	 
	 
	  public function store(CreateFoodRequest $request)
    {
        $input = $request->all();
        $cacheUpload = false;
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->foodRepository->model());
        try {
            $food = $this->foodRepository->create($input);
            $food->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                if ( $cacheUpload ) {
                    $mediaItem = $cacheUpload->getMedia('image')->last();
                    $mediaItem->copy($food, 'image');
					$id=$food['id'];
					//print_r($food);
					//die();
					DB::table('media')->where('model_id',$id)->update(['model_id'=>'0']); 

					   $data=Media::find($mediaItem['id']);
					   $data->model_id=$id;
					   $data->model_type='App\Models\Food';
					  $data->save();
					  
                } else {
                    Flash::error(__('lang.saved_image_failed', ['operator' => __('lang.food')]));
                }
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        if ( $cacheUpload ) {
            Flash::success(__('lang.saved_successfully', ['operator' => __('lang.food')]));
        }

        return redirect(route('foods.index'));
    }
   /* public function storenew(CreateFoodRequest $request)
    {
        $input = $request->all();
       // $cacheUpload = true;
       // $cacheUpload = true;
		
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->foodRepository->model());
        try {
            $food = $this->foodRepository->create($input);
			print_r($food['id']);

            $food->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                if ( $cacheUpload ) {
                    $mediaItem = $cacheUpload->getMedia('image')->last();
					//echo '<br>'.$input['image'];
					//echo '<br>';
				//	echo '<br>';
//print_r($mediaItem);
				//	die();
				$id=$food['id'];
			   $food = $this->foodRepository->update($input, $id);
			   
			   
                    $mediaItem->copy($food, 'image');
					
					
					
					//print_r($mediaItem['id']);
					//   $data=Media::find($mediaItem['id']);
					 //  $data->model_id=$id;
					 //  $data->model_type='App\Models\Food';
					  // $data->save();
				//	die();
					
					
					
					
                } else {
                    Flash::error(__('lang.saved_image_failed', ['operator' => __('lang.food')]));
                }
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        if ( $cacheUpload ) {
            Flash::success(__('lang.saved_successfully', ['operator' => __('lang.food')]));
        }

        return redirect(route('foods.index'));
    }*/

    /**
     * Display the specified Food.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function show($id)
    {
        $this->foodRepository->pushCriteria(new FoodsOfUserCriteria(auth()->id()));
        $food = $this->foodRepository->findWithoutFail($id);

        if (empty($food)) {
            Flash::error('Food not found');

            return redirect(route('foods.index'));
        }

        return view('foods.show')->with('food', $food);
    }

    /**
     * Show the form for editing the specified Food.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function edit($id)
    {
        $this->foodRepository->pushCriteria(new FoodsOfUserCriteria(auth()->id()));
        $food = $this->foodRepository->findWithoutFail($id);
        if (empty($food)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.food')]));
            return redirect(route('foods.index'));
        }
        $category = $this->categoryRepository->pluck('name', 'id');
        if (auth()->user()->hasRole('admin')) {
            $restaurant = $this->restaurantRepository->pluck('name', 'id');
        } else {
            $restaurant = $this->restaurantRepository->myRestaurants()->pluck('name', 'id');
        }

        $extraGroups = ExtraGroup::pluck('name', 'id');
        $extrasSelected = $food->extras()->pluck('id')->toArray();
        $extraGroupsSelected = $food->extraGroups()->distinct('id')->get();
        $customFieldsValues = $food->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->foodRepository->model());
        $hasCustomField = in_array($this->foodRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('foods.edit')
            ->with('food', $food)
            ->with("customFields", isset($html) ? $html : false)
            ->with("restaurant", $restaurant)
            ->with("category", $category)
            ->with("extraGroups", $extraGroups)
            ->with("extraGroupsSelected", $extraGroupsSelected)
            ->with("extrasSelected", $extrasSelected);
    }

    public function getExtraGroup($id, Request $request)
    {
        if ($id) {
            $this->foodRepository->pushCriteria(new FoodsOfUserCriteria(auth()->id()));
            $food = $this->foodRepository->findWithoutFail($id);
            if (empty($food)) {
                Flash::error(__('lang.not_found', ['operator' => __('lang.food')]));
                return redirect(route('foods.index'));
            }
            $extrasSelected = $food->extras()->pluck('id')->toArray();
        } else {
            $extrasSelected = [];
        }

        $extraGroup = ExtraGroup::find($request->post('egid', 0));

        return view('foods.extra_groups')
            ->with("extraGroupsSelected", [$extraGroup])
            ->with("extrasSelected", $extrasSelected);
    }

    /**
     * Update the specified Food in storage.
     *
     * @param int $id
     * @param UpdateFoodRequest $request
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update($id, UpdateFoodRequest $request)
    {
		
        $this->foodRepository->pushCriteria(new FoodsOfUserCriteria(auth()->id()));
        $food = $this->foodRepository->findWithoutFail($id);

        if (empty($food)) {
            Flash::error('Food not found');
            return redirect(route('foods.index'));
        }
        $input = $request->all();
		
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->foodRepository->model());
        try {
            $food = $this->foodRepository->update($input, $id);

            /* fix extra_food  */
            $food->fixExtras();
            /* fix extra_food  */

            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
				//print_r($cacheUpload);
                if ( $cacheUpload ) {

                    $mediaItem = $cacheUpload->getMedia('image')->last();
			//	echo $input['image'];
		//print_r($mediaItem);
		
		 //DB::table('user')->where('email', $userEmail)->update(array('member_type' => $plan));  

	//	die();
		
                    $mediaItem->copy($food, 'image');
					
                } else {
                    Flash::error(__('lang.saved_image_failed', ['operator' => __('lang.food')]));
                }
            }

            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $food->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.food')]));

        return redirect(route('foods.index'));
    }

    /**
     * Remove the specified Food from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (!env('APP_DEMO', false)) {
            $this->foodRepository->pushCriteria(new FoodsOfUserCriteria(auth()->id()));
            $food = $this->foodRepository->findWithoutFail($id);

            if (empty($food)) {
                Flash::error('Food not found');

                return redirect(route('foods.index'));
            }

            $this->foodRepository->delete($id);

            Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.food')]));

        } else {
            Flash::warning('This is only demo app you can\'t change this section ');
        }
        return redirect(route('foods.index'));
    }

    /**
     * Remove Media of Food
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $food = $this->foodRepository->findWithoutFail($input['id']);
        try {
            if ($food->hasMedia($input['collection'])) {
                $food->getFirstMedia($input['collection'])->delete();
				echo 'deleted ok';
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
