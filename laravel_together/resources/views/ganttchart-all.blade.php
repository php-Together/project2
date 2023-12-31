@extends('layout.layout')
@section('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/ganttchart-all.css">
    <script src="/js/ganttchart.js" defer></script>
    {{-- 모달 js, css --}}
    <link rel="stylesheet" href="/css/insert_detail.css">
	<script src="/js/insert_detail.js" defer></script>
@endsection
@section('title', '전체간트차트')
@section('main')
<div class="gantt-btn-wrap">
    <input class="gantt-search" type="input" id="keySearch" onkeyup="enterkeySearch()" placeholder="'업무명'으로 검색">
    <div class="filter-div">
        <div onclick="changeStyle(this)" id="list1" class="gantt-dropdown-check-list" tabindex="100">
            <div class="gantt-span">
                <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                <span>상태</span>
            </div>
            <ul class="gantt-items">
                <li><input id="statusAll" type="radio" name="status" value="전체" checked onclick="is_checked_status(event)">
                    <div class="gantt-color gantt-statusAll"></div><label for="statusAll" class="gantt-item">전체</label>
                </li>
                <li><input id="status1" type="radio" name="status" value="시작전" onclick="is_checked_status(event)">
                    <div class="gantt-color gantt-status1"></div><label for="status1" class="gantt-item">시작전</label>
                </li>
                <li><input id="status2" type="radio" name="status" value="진행중" onclick="is_checked_status(event)">
                    <div class="gantt-color gantt-status2"></div><label for="status2" class="gantt-item">진행중</label>
                </li>
                <li><input id="status3" type="radio" name="status" value="피드백" onclick="is_checked_status(event)">
                    <div class="gantt-color gantt-status3"></div><label for="status3" class="gantt-item">피드백</label>
                </li>
                <li><input id="status4" type="radio" name="status" value="완료" onclick="is_checked_status(event)">
                    <div class="gantt-color gantt-status4"></div><label for="status4" class="gantt-item">완료</label>
                </li>
            </ul>
        </div>
        <div id="list2" class="gantt-dropdown-check-list" tabindex="100">
            <div class="gantt-span">
                <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                <span>중요도</span>
            </div>
            <ul class="gantt-items">
                <li><input id="priorityAll" type="radio" name="priority" value="priorityAll">
                    <label for="priorityAll" class="gantt-item">전체</label>
                </li>
                <li><input id="priority1" type="radio" name="priority" value="priority1"><img class="gantt-rank" src="/img/gantt-bisang.png" alt="">
                    <label for="priority1" class="gantt-item">긴급</label>
                </li>
                <li><input id="priority2" type="radio" name="priority" value="priority2"><img class="gantt-rank" src="/img/gantt-up.png" alt="">
                    <label for="priority2" class="gantt-item">높음</label>
                </li>
                <li><input id="priority3" type="radio" name="priority" value="priority3"><img class="gantt-rank" src="/img/gantt-line.png" alt="">
                    <label for="priority3" class="gantt-item">보통</label>
                </li>
                <li><input id="priority4" type="radio" name="priority" value="priority4"><img class="gantt-rank" src="/img/gantt-down.png" alt="">
                    <label for="priority4" class="gantt-item">낮음</label>
                </li>
                <li><input id="priorityNot" type="radio" name="priority" value="priorityNot">
                    <label for="priorityNot" class="gantt-item">없음</label>
                </li>
            </ul>
        </div>
        <div id="list3" class="gantt-dropdown-check-list" tabindex="100">
            <div class="gantt-span">
                <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                <span>담당자</span>
            </div>
            <ul class="gantt-items">
                {{-- <li><input id="resAll" type="radio" name="respon" checked onclick="is_checked_respon(event)">
                    <label class="gantt-item" for="resAll">전체</label>
                </li>
                @php
                    $resNames = array_unique(array_column($data['task'], 'res_name'));
                    $resNames = array_filter($resNames, function($name) {
                        return $name !== null;
                    });
                    $resNames[] = null; // null 값을 배열에 추가하여 '없음'을 마지막에 표시
                @endphp

                @foreach($resNames as $index => $resName)
                    <li>
                        @if ($resName !== null)
                            <input id="res{{ $index + 1 }}" type="radio" name="respon" onclick="is_checked_respon(event)">
                            <label for="res{{ $index + 1 }}" class="gantt-item">{{ $resName }}</label>
                        @else
                            <input id="res-none" type="radio" name="respon" onclick="is_checked_respon(event)">
                            <label for="res-none" class="gantt-item">없음</label>
                        @endif
                    </li>
                @endforeach --}}
            </ul>
        </div>
        <div id="list4" class="gantt-dropdown-check-list" tabindex="100">
            <div class="gantt-span">
                <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                <span>시작일</span>
            </div>
            <ul class="gantt-items">
                <li><input name="start" type="radio" id="start1" checked onclick="is_checked_start(event)">
                    <label for="start1" class="gantt-item">전체</label>
                </li>
                <li><input name="start" type="radio" id="start2" onclick="is_checked_start(event)">
                    <label for="start2" class="gantt-item">오늘</label>
                </li>
                <li><input name="start" type="radio" id="start3" onclick="is_checked_start(event)">
                    <label for="start3" class="gantt-item">이번주</label>
                </li>
                <li><input name="start" type="radio" id="start4" onclick="is_checked_start(event)">
                    <label for="start4" class="gantt-item">이번달</label>
                </li>
            </ul>
        </div>
        <div id="list5" class="gantt-dropdown-check-list" tabindex="100">
            <div class="gantt-span">
                <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                <span>마감일</span>
            </div>
            <ul class="gantt-items">
                <li><input name="end" type="radio" id="end1" checked onclick="is_checked_end(event)">
                    <label for="end1" class="gantt-item">전체</label>
                </li>
                <li><input name="end" type="radio" id="end2" onclick="is_checked_end(event)">
                    <label for="end2" class="gantt-item">오늘</label>
                </li>
                <li><input name="end" type="radio" id="end3" onclick="is_checked_end(event)">
                    <label for="end3" class="gantt-item">이번주</label>
                </li>
                <li><input name="end" type="radio" id="end4" onclick="is_checked_end(event)">
                    <label for="end4" class="gantt-item">이번달</label>
                </li>
            </ul>
        </div>
    </div>
        {{-- <div class="add-btn-section">
        <button class="gantt-add-btn" onclick="openTaskModal(0)">업무추가</button>
        </div> --}}
        {{-- <button class="gantt-update-btn gantt-add-btn" type="submit">업무수정</button> --}}
</div>
    <!-- 팝업 모달 창 -->
    {{-- <div id="ganttPopupModal" class="gantt-update-modal">
        <div class="gantt-modal-content">
            <p class="gantt-modal-content-p" id="ganttPopupMessage"></p>
        </div>
    </div> --}}
    <div class="gantt-content-wrap">
        <section class="gantt-all-task scroll-style-parent">
            <div class="gantt-task-wrap">
                <div class="gantt-task-header">
                    <div class="gantt-task-header-div" style="width: 34%">
                        <span class="gantt-order">업무명</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                    <div class="gantt-task-header-div" style="width: 14%">
                        <span class="gantt-order">담당자</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                    <div class="gantt-task-header-div" style="width: 16%">
                        <span class="gantt-order">상태</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                    <div class="gantt-task-header-div" style="width: 18%">
                        <span class="gantt-order">시작일</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                    <div class="gantt-task-header-div" style="width: 18%">
                        <span class="gantt-order">마감일</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                </div>
                {{-- 데이터 시작 --}}
                <div class="gantt-task-body">
                    @forelse($data as $key => $projectitem)
                        <div class="gantt-project" id="gantt-task-{{$projectitem->project_id}}">
                            <div class="gantt-project-title">{{$projectitem->project_title}}</div>
                            @if (isset($projectitem->depth_0))
                            @forelse ($projectitem->depth_0 as $taskitem)
                                <div class="gantt-task" id="gantt-task-{{$taskitem->task_id}}">
                                    {{-- 업무 pk --}}
                                    <div class="gantt-editable-div editable">
                                        <button class="gantt-task-detail-click"><span class="gantt-task-detail-click-span">…</span></button>
                                        <div class="gantt-detail" style="display: none">
                                            <button class="gantt-detail-btn" onclick="openTaskModal(1,0,{{$taskitem->task_id}})">자세히보기</button>
                                        </div>
                                        <div class="taskKey" style="display: none">{{$taskitem->task_number}}</div>
                                        <div class="taskChildPosition" style="display: none"></div>
                                        <div class="taskName editable-title" spellcheck="false">{{$taskitem->title}}</div>
                                        {{-- 업무 제목--}}
                                    </div>
                                    <div class="responName"><span class="respon-name-span" id="responNameSpan">{{$taskitem->res_name}}</span></div>
                                    {{-- 담당자 아이디/유저데이터에 이름--}}
                                    <div class="gantt-status-name">
                                        <div class="statusName gantt-status-color" data-status="{{$taskitem->sta_name}}">
                                            <span class="status-name-span" id="statusNameSpan">{{$taskitem->sta_name}}</span>
                                        </div>
                                    {{-- 업무상태 아이디/베이스데이터에 네임--}}
                                    </div>
                                    <div class="gantt-task-4">
                                        <input type="date" class="start-date" name="start" id="start-row{{$taskitem->task_id}}" onchange="test({{$taskitem->task_id}});" value="{{$taskitem->start_date}}">
                                    {{-- 업무 시작일--}}
                                    </div>
                                    <div class="gantt-task-5">
                                        <input type="date" class="end-date" name="end" id="end-row{{$taskitem->task_id}}" onchange="test({{$taskitem->task_id}});" value="{{$taskitem->end_date}}">
                                    {{-- 업무 마감일--}}
                                    </div>
                                </div>
                                @if (isset($taskitem->depth_1))
                                @forelse ($taskitem->depth_1 as $taskitem2)
                                    <div class="gantt-task gantt-child-task" id="gantt-task-{{$taskitem2->task_id}}" parent="{{$taskitem2->task_parent}}">
                                        <div class="gantt-editable-div editable">
                                            <button class="gantt-task-detail-click"><span class="gantt-task-detail-click-span">…</span></button>
                                            <div class="gantt-detail" style="display: none">
                                                <button class="gantt-detail-btn" onclick="openTaskModal(1,0,{{$taskitem2->task_id}})">자세히보기</button>
                                            </div>     
                                            <div class="taskKey" style="display: none">{{$taskitem2->task_number}}</div>
                                            <div class="taskChildPosition"></div>
                                            <div class="taskName editable-title" spellcheck="false">{{$taskitem2->title}}</div>
                                        </div>
                                        <div class="responName"><span class="respon-name-span" id="responNameSpan">{{$taskitem2->res_name}}</span></div>
                                        <div class="gantt-status-name">
                                            <div class="statusName gantt-status-color" data-status="{{$taskitem2->sta_name}}">
                                                <span class="status-name-span" id="statusNameSpan">{{$taskitem2->sta_name}}</span>
                                            </div>
                                        </div>
                                        <div class="gantt-task-4">
                                            <input type="date" class="start-date" name="start" id="start-row{{$taskitem2->task_id}}" onchange="test({{$taskitem2->task_id}});" value="{{$taskitem2->start_date}}">
                                        </div>
                                        <div class="gantt-task-5">
                                            <input type="date" class="end-date" name="end" id="end-row{{$taskitem2->task_id}}" onchange="test({{$taskitem2->task_id}});" value="{{$taskitem2->end_date}}">
                                        </div>
                                    </div>
                                @empty
                                    <div></div>
                                @endforelse
                                @endif
                            @empty
                                <div></div>
                            @endforelse
                            @endif
                        </div>
                    @empty
                       <div></div>
                    @endforelse
                </div>
            </div>
            <div class="gantt-chart-wrap">
                <div class="gantt-chart-container">
                    <div class="gantt-chart-header">
                        <div class="gantt-header-scroll">
                            {{-- 날짜를 가로로 나열할 부분 --}}
                        </div>
                    </div>
                    <div class="gantt-chart-body">
                        @forelse ($data as $key => $projectitem)
                            <div class="gantt-chart" id="gantt-chart-{{$projectitem->project_id}}">
                                @php
                                    $startDate = new DateTime('2024-01-01');
                                    $endDate = new DateTime('2024-03-31');

                                    for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                        echo "<div id='row" . ($projectitem->project_id) . "-" . $date->format('Ymd') . "'></div>";
                                    }
                                @endphp
                            </div>
                            @if (isset($projectitem->depth_0))
                            @forelse ($projectitem->depth_0 as $taskitem)
                                <div class="gantt-chart" id="gantt-chart-{{$taskitem->task_id}}">
                                    @php
                                        $startDate = new DateTime('2024-01-01');
                                        $endDate = new DateTime('2024-03-31');

                                        for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                            echo "<div id='row" . ($taskitem->task_id) . "-" . $date->format('Ymd') . "'></div>";
                                        }
                                    @endphp
                                </div>
                                @if (isset($taskitem->depth_1))
                                @forelse ($taskitem->depth_1 as $taskitem2)
                                    <div class="gantt-chart" id="gantt-chart-{{$taskitem2->task_id}}">
                                        @php
                                            $startDate = new DateTime('2024-01-01');
                                            $endDate = new DateTime('2024-03-31');

                                            for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                                echo "<div id='row" . ($taskitem2->task_id) . "-" . $date->format('Ymd') . "'></div>";
                                            }
                                        @endphp
                                    </div>
                                @empty
                                    
                                @endforelse
                                @endif
                            @empty
                            @endforelse
                            @endif
                        @empty
                        @endforelse    
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- @include('modal.insert') include 순서 중요: 작성/상세
    @include('modal.detail') --}}

   
@endsection