<?php

namespace App\Http\Livewire;


use App\Models\Ads;
use App\Models\Image;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Adds extends Component
{
    public $ads;
    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $confirmingAdsAdd = false;
    public $confirmingAdsDeletion = false;
    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];
    public $images = [];
    protected $rules = [

        'ads.category' => 'required|string|min:4',
        'ads.description' => 'required|string|min:4',
        'ads.title' => 'required|string|min:4',
        'ads.location' => 'required|string|min:4',
        'ads.price' => 'required|numeric|min:0',
        'ads.main_images' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
        'images.*'=> 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
    ];
    use WithPagination;
    use WithFileUploads;
    public function render()
    {

        $adds = Ads::where('user_id', auth()->user()->id)
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('price', 'like', '%' . $this->q . '%')
                        ->orWhere('description', 'like', '%' . $this->q . '%')
                        ->orWhere('category', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        $query = $adds->toSql();
        $adds = $adds->paginate(10);
        return view('livewire.adds', [
            'adds' => $adds,
            'query' => $query
        ]);
    }
    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }
    public function confirmAdsDeletion($id)
    {
        $this->confirmingAdsDeletion = $id;
    }
    public function deleteAds(Ads $ads)
    {
        $ads->delete();
        $this->confirmingAdsDeletion = false;
        session()->flash('message', 'ads Deleted Successfully');
    }

    public function confirmAdsAdd()
    {
        $this->reset(['ads']);
        $this->confirmingAdsAdd = true;
    }
    public function saveAds()
    {
        $this->validate();

        if (isset($this->ads->id)) {
            $this->ads->save();
            session()->flash('message', 'Ads Saved Successfully');
        } else {
            if ($this->ads['main_image']) {
                $imagePath = $this->ads['main_image'];
                $imageName = uniqid() . '.' . $imagePath->getClientOriginalExtension();
                $main_image_path=$imagePath->storeAs('public/images',$imageName);
                $img_url=asset('storage/images/' . $imageName);
                //$main_imageUrl = $main_image_path->getClientOriginalName();
                //<img src="{{ asset('storage/images/' . $imageName) }}" alt="Image">

            }
            $ads = auth()->user()->ads()->create([
                'title' => $this->ads['title'],
                'category' => $this->ads['category'],
                'description' => $this->ads['description'],
                'price' => $this->ads['price'],
                'location' => $this->ads['location'],
                'main_image' => $img_url,


            ]);
            $ads_id=$ads->id;

            if (!empty($this->images)) {
                foreach ($this->images as $image) {
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $file=$image->storeAs('public/images',$fileName);
                    $fileUrl=asset('storage/images/' . $fileName);
                    Image::create([
                        'path' => $fileUrl,
                        'ads_id' => $ads_id,
                    ]);
                }
            }
            session()->flash('message', 'Ads Added Successfully');
        }

        $this->confirmingAdsAdd = false;
    }
}
