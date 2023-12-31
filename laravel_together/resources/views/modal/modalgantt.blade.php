@extends('layout.layout')
@section('gantt_link')
    <link rel="stylesheet" href="/css/ganttchart.css">
    <script src="/js/ganttchart.js" defer></script>
    {{-- 모달 js, css --}}
    <link rel="stylesheet" href="/css/insert_detail.css">
	<script src="/js/insert_detail.js" defer></script>
@endsection
@section('title', '간트차트')
@section('main')
    <div class="first_menu">
        <div class="menu_title">
            <div class="project_color"></div>
            <div>
                <input type="text" name="title" placeholder="프로젝트명">
                {{-- <br> --}}
                <textarea name="content" id="content" placeholder="설명"></textarea>
            </div>
        </div>
        <div class="date_set">
            <label for="d_day"> D-day
                <span class="date"></span>
            </label>
            <label for="start_date"> 시작일
                <input class="date" type="date" name="start_date">
            </label>
            <label for="end_date"> 마감일
                <input class="date" type="date" name="end_date">
            </label>
        </div>
    </div>
    <div class="tabset">
        <a href="" class="tabmenu">피드</a>
        <button class="gantt-tabmenu active" onclick="openTab(event,gantt)">간트차트</button>
    </div>
    {{-- <div class="hr"></div> --}}
    {{-- 피드공통 헤더끝 --}}
    <div class="gantt-btn-wrap">
        <input class="gantt-search" type="input" id="keySearch" onkeyup="enterkeySearch()" placeholder="   업무명, 업무번호 검색">
        <div>
            <img class="gantt-filter" src="/img/gantt-filter.png" alt="filter">
            <div id="list1" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>상태</span>
                    <img src="/img/table.png" alt="">
                </div>
                <ul class="gantt-items">
                    <li><input type="checkbox" name="status" value="status1" onclick="getCheckboxValue()" checked><div class="gantt-color gantt-status1"></div><span class="gantt-item">시작전</span></li>
                    <li><input type="checkbox" name="status" value="status2" onclick="getCheckboxValue()" checked><div class="gantt-color gantt-status2"></div><span class="gantt-item">진행중</span></li>
                    <li><input type="checkbox" name="status" value="status3" onclick="getCheckboxValue()" checked><div class="gantt-color gantt-status3"></div><span class="gantt-item">피드백</span></li>
                    <li><input type="checkbox" name="status" value="status4" onclick="getCheckboxValue()" checked><div class="gantt-color gantt-status4"></div><span class="gantt-item">완료</span></li>
                </ul>
            </div>
            <div id="list2" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>우선순위</span>
                    <img src="/img/table.png" alt="">
                </div>
                <ul class="gantt-items">
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><img class="gantt-rank" src="/img/gantt-bisang.png" alt=""><span
                            class="gantt-item">긴급</span></li>
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><img class="gantt-rank" src="/img/gantt-up.png" alt=""><span
                            class="gantt-item">높음</span></li>
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><img class="gantt-rank" src="/img/gantt-line.png" alt=""><span
                            class="gantt-item">보통</span></li>
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><img class="gantt-rank" src="/img/gantt-down.png" alt=""><span
                            class="gantt-item">낮음</span></li>
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><span class="gantt-item">없음</span></li>
                </ul>
            </div>
            <div id="list3" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>담당자</span>
                    <img src="/img/table.png" alt="">
                </div>
                <ul class="gantt-items">
                    @foreach (array_unique(array_column($data, 'name')) as $itemName)
                        <li><input type="checkbox" onclick="getCheckboxValue()"><span class="gantt-item">{{ $itemName }}</span></li>
                    @endforeach
                </ul>
            </div>
            <div id="list4" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>시작일</span>
                    <img src="/img/table.png" alt="">
                </div>
                <ul class="gantt-items">
                    <li><input name="start" type="radio" onclick="getCheckboxValue()" checked><span class="gantt-item">전체</span></li>
                    <li><input name="start" type="radio" onclick="getCheckboxValue()"><span class="gantt-item">오늘</span></li>
                    <li><input name="start" type="radio" onclick="getCheckboxValue()"><span class="gantt-item">이번주</span></li>
                    <li><input name="start" type="radio" onclick="getCheckboxValue()"><span class="gantt-item">이번달</span></li>
                </ul>
            </div>
            <div id="list5" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>마감일</span>
                    <img src="/img/table.png" alt="">
                </div>
                <ul class="gantt-items">
                    <li><input name="end" type="radio" checked><span class="gantt-item">전체</span></li>
                    <li><input name="end" type="radio"><span class="gantt-item">오늘</span></li>
                    <li><input name="end" type="radio"><span class="gantt-item">이번주</span></li>
                    <li><input name="end" type="radio"><span class="gantt-item">이번달</span></li>
                </ul>
            </div>
            <button class="gantt-add-btn" onclick="openTaskModal(0)">업무추가</button>
            {{-- <button class="gantt-update-btn gantt-add-btn" type="submit">업무수정</button> --}}
        </div>
    </div>
    <!-- 팝업 모달 창 -->
    <div id="ganttPopupModal" class="gantt-update-modal">
        <div class="gantt-modal-content">
            <p class="gantt-modal-content-p" id="ganttPopupMessage"></p>
        </div>
    </div>
    <div class="gantt-content-wrap">
        <section class="gantt-all-task">
            <div class="gantt-task-wrap">
                <div class="gantt-task-header">
                    <div class="gantt-task-header-div" onclick="orderDropdown('orderTask')" style="width: 30%">
                        <span class="gantt-order">업무명</span>
                        <img src="/img/table.png" alt="">
                        <img src="/img/table2.png" alt="" style="display: none">
                    </div>
                    <div class="gantt-task-header-div" onclick="orderDropdown('orderUser')" style="width: 16%">
                        <span class="gantt-order">담당자</span>
                        <img src="/img/table.png" alt="">
                        <img src="/img/table2.png" alt="" style="display: none">
                    </div>
                    <div class="gantt-task-header-div" onclick="orderDropdown('orderStatus')" style="width: 18%">
                        <span class="gantt-order">상태</span>
                        <img src="/img/table.png" alt="">
                        <img src="/img/table2.png" alt="" style="display: none">
                    </div>
                    <div class="gantt-task-header-div" onclick="orderDropdown('orderStart')" style="width: 18%">
                        <span class="gantt-order">시작일</span>
                        <img src="/img/table.png" alt="">
                        <img src="/img/table2.png" alt="" style="display: none">
                    </div>
                    <div class="gantt-task-header-div" onclick="orderDropdown('orderEnd')" style="width: 18%">
                        <span class="gantt-order">마감일</span>
                        <img src="/img/table.png" alt="">
                        <img src="/img/table2.png" alt="" style="display: none">
                        <div class="gantt-order-div" id="orderEndDropdown">
                            <button class="gantt-order-task">오름차순</button>
                            <br>
                            <button class="gantt-order-task">내림차순</button>
                        </div>
                    </div>
                </div>
                <div class="gantt-task-body">
                    @foreach ($data as $key => $item)
                        <div class="gantt-task" id="gantt-task-{{$item->id}}">
                            <div class="gantt-editable-div editable">
                                <button class="gantt-task-detail-click">●</button>
                                <div class="gantt-detail" style="display: none">
                                    <button class="gantt-detail-btn" onclick="openTaskModal(1,0,{{$item->id}})">자세히보기</button>
                                    <br>
                                    <button class="gantt-detail-btn" onclick="addSubTask({{$item->id}})">하위업무 추가</button>
                                </div>     
                                <div class="taskKey">{{$item->id}}</div>
                                <div class="taskName editable-title" spellcheck="false" contenteditable="true">{{$item->title}}</div>
                            </div>
                            <div class="responName gantt-update-dropdown"><span>{{$item->name}}</span></div>
                            <div class="gantt-status-name">
                                <div class="statusName gantt-status-color gantt-update-dropdown" data-status="{{$item->task_status_name}}"><span>{{$item->task_status_name}}</span></div>
                            </div>
                            <div class="gantt-task-4">
                                <input type="date" name="start" id="start-row{{$item->id}}" onchange="test({{$item->id}});" value="{{$item->start_date}}">
                            </div>
                            <div class="gantt-task-5">
                                <input type="date" name="end" id="end-row{{$item->id}}" onchange="test({{$item->id}});" value="{{$item->end_date}}">
                            </div>
                        </div>
                    @endforeach
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
                        @foreach ($data as $key => $item)
                            <div class="gantt-chart" id="gantt-chart-{{$item->id}}">
                                @php
                                    $startDate = new DateTime('2023-12-01');
                                    $endDate = new DateTime('2023-12-31');

                                    for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                        echo "<div id='row" . ($item->id) . "-" . $date->format('Ymd') . "'></div>";
                                    }
                                @endphp
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('modal.insert') <!-- include 순서 중요: 작성/상세 -->
    @include('modal.detail')

   
@endsection