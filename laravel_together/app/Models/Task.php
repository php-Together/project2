<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Attachment;

class Task extends Model // 업무/공지
{
  use HasFactory, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'project_id',
    'task_responsible_id',
    'task_writer_id',
    'task_status_id',
    'priority_id',
    'category_id',
    'task_number',
    'task_depth',
    'task_parent',
    'title',
    'content',
    'start_date',
    'end_date',
    'depth_1',
  ];

  protected $primaryKey = 'id';
  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  // 모델 연관 관리
  public function comments()
  {
    // return $this->belongsTo(Task::class,'task_id','id'); 이걸 생략하면        
    return $this->hasMany(Comment::class);
  }
  public function attachments()
  {
    return $this->hasMany(Attachment::class);
  }
  public function projects()
  {
    return $this->belongsTo(Project::class);
  }

  // task 깊이별로 가져오기
  public static function depth_pj($task_depth, $project_id)
  {
    $result = DB::select(
      "SELECT 
                tsk.id
                ,tsk.project_id
                ,pj.project_title
                ,tsk.task_responsible_id
                ,res.name as res_name
                ,tsk.task_writer_id
                ,wri.name as wri_name
                ,tsk.task_status_id
                ,base.data_content_name as status_name
                ,tsk.priority_id
                ,base2.data_content_name as priority_name
                ,tsk.category_id
                ,base3.data_content_name as category_name
                ,tsk.task_number
                ,tsk.task_parent
                ,tsk.task_depth
                ,tsk.title
                ,tsk.content
                ,tsk.start_date
                ,tsk.end_date
                ,tsk.created_at
                ,tsk.updated_at
                ,tsk.deleted_at
            FROM tasks tsk
              LEFT JOIN basedata base 
                ON tsk.task_status_id = base.data_content_code
                AND base.data_title_code = '0'
              LEFT JOIN basedata base2 
                ON tsk.priority_id = base2.data_content_code
                AND base2.data_title_code = '1'
              LEFT JOIN basedata base3 
                ON tsk.category_id = base3.data_content_code
                AND base3.data_title_code = '2'
              LEFT JOIN users res
                ON tsk.task_responsible_id = res.id
              LEFT JOIN users wri
                ON tsk.task_writer_id = wri.id
              LEFT JOIN projects pj
                ON tsk.project_id = pj.id
            WHERE tsk.task_depth = " . $task_depth
            ." AND tsk.project_id = " . $project_id
            ." AND tsk.category_id = 0 "
            ." AND tsk.deleted_at IS NULL "
            ." ORDER BY tsk.created_at "
    );

    return $result;
  }

  public static function depth_tsk($task_depth, $task_parent)
  {
    $result = DB::select(
      "SELECT 
                tsk.id
                ,tsk.project_id
                ,pj.project_title
                ,tsk.task_responsible_id
                ,res.name as res_name
                ,tsk.task_writer_id
                ,wri.name as wri_name
                ,tsk.task_status_id
                ,base.data_content_name as status_name
                ,tsk.priority_id
                ,base2.data_content_name as priority_name
                ,tsk.category_id
                ,base3.data_content_name as category_name
                ,tsk.task_number
                ,tsk.task_parent
                ,tsk.task_depth
                ,tsk.title
                ,tsk.content
                ,tsk.start_date
                ,tsk.end_date
                ,tsk.created_at
                ,tsk.updated_at
                ,tsk.deleted_at
            FROM tasks tsk
              LEFT JOIN basedata base 
                ON tsk.task_status_id = base.data_content_code
                AND base.data_title_code = '0'
              LEFT JOIN basedata base2 
                ON tsk.priority_id = base2.data_content_code
                AND base2.data_title_code = '1'
              LEFT JOIN basedata base3 
                ON tsk.category_id = base3.data_content_code
                AND base3.data_title_code = '2'
              LEFT JOIN users res
                ON tsk.task_responsible_id = res.id
              LEFT JOIN users wri
                ON tsk.task_writer_id = wri.id
              LEFT JOIN projects pj
                ON tsk.project_id = pj.id
            WHERE tsk.task_depth = " . $task_depth
            ." AND tsk.category_id = 0 "
            ." AND tsk.task_parent = " . $task_parent
            ." AND tsk.deleted_at IS NULL "
            ." ORDER BY tsk.created_at "
    );

    return $result;
  }

  // 업무/공지 상세업무 하나 가져오기
  public static function task_detail($id)
  {
    $result = DB::select(
      "SELECT 
            tsk.id
            ,tsk.project_id
            ,pj.project_title
            ,pj_clr.data_content_name project_color
            ,tsk.task_responsible_id
            ,res.name res_name
            ,tsk.task_writer_id
            ,wri.name wri_name
            ,tsk.task_status_id
            ,base.data_content_name status_name
            ,tsk.priority_id
            ,base2.data_content_name priority_name
            ,tsk.category_id
            ,base3.data_content_name category_name
            ,tsk.task_number
            ,tsk.task_parent
            ,tsk.task_depth
            ,tsk.title
            ,tsk.content
            ,tsk.start_date
            ,tsk.end_date
            ,tsk.created_at
            ,tsk.updated_at
        FROM tasks tsk
          LEFT JOIN projects pj
            ON tsk.project_id = pj.id
          LEFT JOIN users res
            ON tsk.task_responsible_id = res.id
          LEFT JOIN users wri
            ON tsk.task_writer_id = wri.id
          LEFT JOIN basedata base 
            ON tsk.task_status_id = base.data_content_code
            AND base.data_title_code = '0'
          LEFT JOIN basedata base2 
            ON tsk.priority_id = base2.data_content_code
            AND base2.data_title_code = '1'
          LEFT JOIN basedata base3 
            ON tsk.category_id = base3.data_content_code
            AND base3.data_title_code = '2'
          LEFT JOIN basedata pj_clr 
            ON pj.color_code_pk = pj_clr.data_content_code
            AND pj_clr.data_title_code = '3'
        WHERE tsk.id = " . $id
        ." AND tsk.deleted_at IS NULL "
    );

    return $result;
  }

  // 상위업무 데려오기
  public static function task_detail_parents($depth, $id)
  {
    $result = [];
    // depth 값을 보고 셀렉트 결정
    if ($depth !== '0') {
        $parent = DB::select(
        "SELECT 
        tsk.id
        ,res.name responsible_name
         ,sta.data_content_name status_name
         ,pri.data_content_name priority_name
        ,tsk.title
        ,tsk.task_parent
        ,tsk.start_date
        ,tsk.end_date
      FROM tasks tsk
        JOIN tasks chd
          ON tsk.id = chd.task_parent
         AND chd.id = ". $id ."
          JOIN users res
           ON tsk.task_responsible_id = res.id
         JOIN basedata sta
           ON tsk.task_status_id = sta.data_content_code
          AND sta.data_title_code = 0
         JOIN basedata pri
           ON tsk.priority_id = pri.data_content_code
          AND pri.data_title_code = 1"
        ." WHERE tsk.deleted_at IS NULL "
        . " LIMIT 1 "
      );
      $result[] = $parent[0];
    }
    if ($depth !== '1') {
        $grandParent[] = DB::select(
            "SELECT 
          tsk.id
          ,res.name responsible_name
          ,sta.data_content_name status_name
          ,pri.data_content_name priority_name
          ,tsk.title
          ,tsk.start_date
          ,tsk.end_date
        FROM tasks tsk
          JOIN tasks chd
            ON tsk.id = chd.task_parent
          AND chd.id = ". $result[0]->id ."
            JOIN users res
            ON tsk.task_responsible_id = res.id
          JOIN basedata sta
            ON tsk.task_status_id = sta.data_content_code
            AND sta.data_title_code = 0
          JOIN basedata pri
            ON tsk.priority_id = pri.data_content_code
            AND pri.data_title_code = 1"
        ." WHERE tsk.deleted_at IS NULL "
        . " LIMIT 1 "
      );  
      $result[] = $grandParent[0][0];
    }
    return $result; // [0]이 바로 상위, [1]이 상상위
  }

  // 하위업무 데려오기
  public static function task_detail_children($id)
  {
    $result = DB::select(
      "SELECT
                tsk.id
                ,tsk.task_responsible_id
                ,res.name res_name
                ,tsk.task_status_id
                ,base.data_content_name status_name
                ,tsk.priority_id
                ,base2.data_content_name priority_name
                ,tsk.task_parent
                ,tsk.task_depth
                ,tsk.title
                ,tsk.start_date
                ,tsk.end_date
            FROM tasks tsk
              JOIN users res
                ON tsk.task_responsible_id = res.id
              JOIN basedata base 
                ON tsk.task_status_id = base.data_content_code
               AND base.data_title_code = '0'
              JOIN basedata base2 
                ON tsk.priority_id = base2.data_content_code
               AND base2.data_title_code = '1'
            WHERE tsk.task_parent = " . $id
            ." AND tsk.deleted_at IS NULL "
    );
    return $result;
  }

  // 업무/공지 댓글
  public static function task_detail_comment($id)
  {
    $result = DB::select(
      "SELECT
                cmt.id
                ,cmt.task_id
                ,cmt.user_id
                ,us.name user_name
                ,cmt.content
                ,cmt.created_at
                ,cmt.updated_at
            FROM comments cmt
              JOIN users us
                ON cmt.user_id = us.id
            WHERE cmt.task_id = " . $id
            ." AND cmt.deleted_at IS NULL "
    );
    return $result;
  }
}
