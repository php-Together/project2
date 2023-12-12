<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years');
        return [
            
            'project_id'=>$this->faker->randomNumber(4), // 프로젝트 pk
            'task_responsible_id'=>$this->faker->randomNumber(1), // 담당자 pk
            'task_writer_id'=>$this->faker->randomNumber(2), // 작성자 pk
            'attachment_id'=>$this->faker->numberBetween(0,2), // 첨부파일 pk
            'task_status_id'=>$this->faker->numberBetween(0,4), // 업무상태 pk
            'priority_id'=>$this->faker->randomNumber(0,4), // 우선순위 pk
            'category_id'=>$this->faker->randomNumber(0,1), // 카테고리 pk
            'task_number'=>$this->faker->randomNumber(4), // 업무번호
            'task_parent'=>$this->faker->randomNumber(1), // 상위업무
            'task_depth'=>$this->faker->task_depth(),// 업무깊이 1
            'title'=>$this->faker->sentence(50), // 제목 50
            'content'=>$this->faker->sentence(500), // 내용 500
            'created_at'=>timestamps(), // 작성일자
            'updated_at'=>timestamps(), // 수정일자
            'deleted_at'=>softDeletes(), // 탈퇴일자
            
            
        ];    }}