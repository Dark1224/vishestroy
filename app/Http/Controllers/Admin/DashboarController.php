<?php
namespace App;
namespace App\Http\Controllers\Admin;
use App\fields;
use App\values;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\menu;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
class DashboarController extends Controller
{
    protected $main_menu = array();

    protected function hasChildren($id){
        $menu =  menu::where('parent_id', $id)->orderBy('id')->get();
        if($menu->count() > 0){
            return true;
        }
        return false;
    }

    protected function getChildrenCategory($id, $arr = []){
        $menu = menu::where('parent_id', $id)->orderBy('id')->get();
        foreach($menu as $key => $val){
            $arr['children'][] = $val;
            if($this->hasChildren($val->id)){
                $this->getChildrenCategory($val->id, $arr);
            }
        }
        return $arr;
    }

    public function showCategories(){
        $main_menu =  menu::simplePaginate(16);
        return view('admin.dashboard.menu', ['menu' => $main_menu]);
    }
    public function addcategories(Request $request)
    {
        if($request -> method() == 'POST') {
//            $this->validate($request, [
//                'cat_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            ]);
            $img = '';
            $menu = new menu;
            $menu -> parent_id = $request -> cat_parent;
            $menu -> name = $request -> cat_name;
            if(isset($request -> is_active)) {
                $menu -> active = $request -> is_active;
            }else{
                $menu->active = 0;
            }
            if (isset($request->image)) {
                $img = $request->image[1];
            }
            $menu -> img_path = $img;
            $menu -> save();
            return redirect('admin/categories');
        }else{
            $menu = menu::all();
            return view('admin.dashboard.addMenu', ['menu' => $menu]);
        }
    }

    public function editCategories(Request $request, $id){
        if($request->method() == 'POST'){
//            $this->validate($request, [
//                'cat_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            ]);
            $img = '';
            $menu = menu::find($id);
            $menu->parent_id = $request->cat_parent;
            $menu->name = $request->cat_name;
            if(isset($request->is_active)){
                $menu->active = $request->is_active;
            }else{
                $menu->active = 0;
            }
            if (isset($request->image)) {
                $img = $request->image[1];
            }
            $menu->img_path = $img;
            $menu->save();
            return redirect('admin/categories');
        }else{
            $menu = menu::all();
            $menu_info = menu::find($id);
            return view('admin.dashboard.editMenu', ['id' => $id,'menu_info' => $menu_info, 'menu' => $menu]);

        }
    }

    public function removeCategories($id){
        menu::where('id', $id)->delete();
        return redirect('admin/categories');
    }
    public function showProducts(){
        /*$products =  products::all();*/
        $products =  products::simplePaginate(16);
        return view('admin.dashboard.products', ['products' => $products]);
    }
    public function addProduct(Request $request){
        if($request->method() == 'POST'){

            $img_name = array();
            if($request->has('image')){
                foreach($request->image as $key => $val){
                    $img_name[] = $val;
                }
            }



            $product = new products;
            $product->name = $request->name;
            $product->category = $request->category_name;
            $product->description = $request->description ? $request->description : '';
            $product->img_path = json_encode($img_name);
            $product->manufacturer = $request->manufacturer;
            $product->available = $request->available;
            $product->unit = $request->unit;
            $product->in_package = $request->in_package;
            $product->additional = json_encode($request->additional_info);
            $product->buy_with = json_encode($request->buy_with);
            $product->similar = json_encode($request->similar);
            $product->article = json_encode($request->article);
            if(isset($request->is_active)) {
                $product->is_active = $request->is_active;
            }else{
                $product->is_active = 0;
            }
            if(isset($request->bestseller)) {
                $product->bestseller = $request->bestseller;
            }else{
                $product->bestseller = 0;
            }
            if(isset($request->sel_lout)) {
                $product->sel_lout = $request->sel_lout;
            }else{
                $product->sel_lout = 0;
            }
            if(isset($request->new)){
                $product->new = $request->new;
            }else{
                $product->new = 0;
            }
            $product->delivery = $request->delivery;
            $product->pickup = $request->pickup;
            $product->price = $request->price;
            $product->old_price = $request->old_price == null ? 0 : $request->old_price;
            $product->video = json_encode($request->video);
            $product->save();
            return redirect('admin/products');
        }else{
            $menu = menu::all();
            $products = products::all();
            $manufacturer = values::where('fieldId', 1)->get();
            $unit = values::where('fieldId', 2)->get();
            return view('admin.dashboard.addProduct', ['menu' => $menu, "products" => $products, 'manufacturer' => $manufacturer, 'unit' => $unit]);
        }

    }
    public function editProduct(Request $request, $id){
        if($request->method() == 'POST'){
//            dd($request->additional_info);
//            $this->validate($request, [
//                'cat_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            ]);
            $product = products::find($id);
            $img_name = array();
            if($request->has('image')){
                foreach($request->image as $key => $val){
                    $img_name[] = $val;
                }
            }
            $product->name = $request->name;
            $product->category = $request->category_name;
            $product->description = $request->description;
            $product->img_path =json_encode($img_name);
            $product->manufacturer = $request->manufacturer;
            $product->available = $request->available;
            $product->unit = $request->unit;
            $product->in_package = $request->in_package;
            $product->additional = json_encode($request->additional_info);
            $product->buy_with = json_encode($request->buy_with);
            $product->similar = json_encode($request->similar);
            $product->article = json_encode($request->article);
            if(isset($request->is_active)) {
                $product->is_active = $request->is_active;
            }else{
                $product->is_active = 0;
            }
            if(isset($request->bestseller)) {
                $product->bestseller = $request->bestseller;
            }else{
                $product->bestseller = 0;
            }
            if(isset($request->sel_lout)) {
                $product->sel_lout = $request->sel_lout;
            }else{
                $product->sel_lout = 0;
            }
            if(isset($request->new)){
                $product->new = $request->new;
            }else{
                $product->new = 0;
            }
            $product->delivery = $request->delivery;
            $product->pickup = $request->pickup;
            $product->price = $request->price;
            $product->old_price = $request->old_price;
            $product->video = json_encode($request->video);
            $product->save();
            return redirect('admin/products');
        }else{
            $menu = menu::all();
            $products = products::all();
            $product = products::find($id);
            $manufacturer = values::where('fieldId', 1)->get();
            $unit = values::where('fieldId', 2)->get();
            return view('admin.dashboard.editProduct', ['menu' => $menu, "products" => $products, 'main_product' => $product, 'id' => $id, 'manufacturer' => $manufacturer, 'unit' => $unit]);
        }
    }
    public function removeProduct($id){
        products::where('id', $id)->delete();
        return redirect('admin/products');
    }
    public function getAllImages(Request $request){
        $url = 'images';
        if(isset($request->directory)){
            $url = $request->directory;
        }
        $images = Storage::files($url);
        $directory = Storage::directories($url);
        $res = array('images' => $images, 'directory' => $directory);
        echo json_encode($res);
    }
    public function uploadImage(Request $request){
        $img_name = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = 'images';
            $image->move($destinationPath, $name);
            $img_name = $destinationPath . '/' . $name;

            // resize to small
//            $img = Image::make(public_path($img_name));
//            $img->resize(80, 80);
//            $img->save(public_path().'/images/small'.$name);
            // resize to middle
//            $img = Image::make(public_path($img_name));
//            $img->resize(250, 250);
//            $img->save(public_path().'/images/middle/'.$name);
        }
        echo $img_name;
    }
    public function removeImage(Request $request){
        $image_path = $request->name;
        if(file_exists(public_path($image_path))) {
            unlink(public_path($image_path));
           return Response(['success' => true]);
        }
    }
    public function showFields(){
        $fields = fields::all();
        return view('admin.dashboard.fields', ['fields' => $fields]);
    }
    public function getVals(Request $request){
        if($request->type === 'get'){
            $values = values::where('fieldId', $request->id)->get();
            return Response($values);
        }
        elseif($request->type === 'add'){
            $id = $request->id;
            $val = $request->val;
            $values = new values;
            $values->name = $val;
            $values->fieldId = $id;
            $values -> save();
            return Response($values->id);

        }
        elseif($request->type === 'update'){
            $id = $request->id;
            $val = $request->val;
            $values = values::find($id);
            $values->name = $val;
            $values -> save();
            return Response(1);
        }
        elseif($request->type === 'remove'){
            $id = $request->id;
            values::where('id', $id)->delete();
        }
    }

}
