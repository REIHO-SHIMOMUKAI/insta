<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){
        $all_categories = $this->category->latest()->paginate(10);
        //paginate - returns paged data
        //withTrashed - includes soft-deleted records

        $all_posts = $this->post->all();
        //uncategorized tag count
        $uncategorized_count = 0;

        foreach($all_posts as $p){
            if($p->categoryPosts->count() == 0){
                // the post category is 0
                //Admin画面からcategoryを削除すると、postに割り振られたcategoryが消える。
                //category_postテーブルのその行ごと削除される。
                //例：post_id=7の投稿にcategory_id=8のタグをつける。そのあとcategory_id=8のタグを削除すると、post_id=7の投稿は残るが、category_postテーブルのpost_id=7とcategory_id=8の行は消える。
                //foreachで全投稿を取得するが、$pがpostのid=7のときcategory_postテーブルにその投稿が存在しないので、if文に入る。
                //各投稿に対して、category_postテーブルにその投稿のidが存在しない場合、uncategorized_countが増えていき、uncategorizedのタグの個数をカウントできる。
                $uncategorized_count++;
            }
        }

        return view('admin.categories.index')->with('all_categories', $all_categories)->with('uncategorized_count',$uncategorized_count);
    }

    public function create(Request $request){
        $request->validate([
            'category' => 'required|max:50|unique:categories,name,'

        ]);

        $this->category->name = $request->category;

        $this->category->save();

        return redirect()->route('admin.categories');
    }

    public function delete($id){

        $this->category->destroy($id);

        return redirect()->back();
    }

    public function update(Request $request, $id){

        $category_a = $this->category->findOrFail($id);

        $request->validate([
            'category'.$id => 'required|max:50|unique:categories,name,'.$id
            //don't duplicate other names in categories table, but it is OK to duplicate current name

        ]);

        $category_a->name = $request->input('category'.$id);
        //category is the name of category user entered

        $category_a->save();

        return redirect()->back();
    }

}
