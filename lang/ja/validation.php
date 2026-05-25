<?php

return [

    'required' => ':attribute は必須です。',
    'date' => ':attribute は正しい日付を入力してください。',
    'integer' => ':attribute は整数で入力してください。',

    'exists' => ':attribute が正しく選択されていません。',

    'min' => [
        'numeric' => ':attribute は :min 以上で入力してください。',
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],

    'max' => [
        'numeric' => ':attribute は :max 以下で入力してください。',
        'string' => ':attribute は :max 文字以内で入力してください。',
    ],

    'attributes' => [
        'arrival_date'     => '入庫日',
        'category_id'      => 'お酒の種類名',
        'item_name'        => 'ラベル名',
        'receiving_count'  => '入庫本数',
        'expiration_date'  => '賞味期限日',

        'issuing_date'     => '出庫日',
        'issuing_count'    => '出庫本数',
        'evaluation'       => '評価',
        'repeat'           => 'リピート',
    ],

];
