<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = "category_post";
    //通常laravelではテーブル名が複数形になっているものに対してModelsのクラス名を単数にすることでコネクトできるが、
    //今回category_postテーブルは複数形にしていない。ここで宣言しないといけない。
    protected $fillable = ['category_id','post_id'];
    //  $post->save()の処理(mySQLにデータを詰める)を配列でやりたい場合、$post->create($array)のようにする。
    //配列でのデータセーブはこのままだとできないので、Modelに$fillableを定義する必要がある。
    public $timestamps = false;
    //CategoryPostテーブルではtimestampsは使わない
    //こうしておかないと作成時・更新時にエラーが出る
    public function category(){
        return $this->belongsTo(Category::class);
    }
    //function postを定義しない理由：diplayにはpostテーブルの項目を使わないから

}
