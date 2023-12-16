<head>
    <link rel="stylesheet" href="/css/messenger.css">
    <meta name="csrf-token">
</head>
<body>
    <div id="m-myModal" class="m-modal">
    <div class="m-modal-content">
        <span class="m-modal-close" onclick="mcloseModal()">&times;</span>
       <!-- 탭 목록 -->
<ul class="tabs">
    <li class="tab tab-active" onclick="openTab('tab1')"><img class="tab-icon" src="/img/icon-Subtract.png" alt=""></li>
    <li class="tab" onclick="openTab('tab2')"><img class="tab-icon" src="/img/icon-group.png" alt=""></li>
    {{-- <li class="tab" onclick="openTab('tab3')">탭 3</li>
    <li class="tab" onclick="openTab('tab4')">탭 4</li> --}}
</ul>

<!-- 탭 내용 -->
<div id="tab1" class="tab-content">
    <h3>탭 1 내용</h3>
    <p>이곳에 탭 1의 내용이 들어갑니다.</p>
</div>

<div id="tab2" class="tab-content">
    

    {{-- 친구 검색 bar --}}
    <div class="friend-searchbar-div">
    <div class="friend-searchbar">
        <input type="search" class="f-search" placeholder="친구 검색"> 
    <button class="search-icon"><img src="/img/icon-search.png" alt=""></button>
    </div>
    {{-- 친구 추가 버튼 --}}
    <button class="add-button" type="button" onclick="openModal()">+</button>
    
  </div>

    
    {{-- side title : 친구요청 --}}
    <div class="m-side-title-div"><p class="m-side-title">친구 요청</p><div class="notice-count">2</div></div>
    
    <div class="messenger-user-div m-received-bg">
        <div class="user-profile"><img src="/img/profile-img.png" alt=""></div>
        <p class="user-text">누구셈</p>
        <p class="user-text">gffds@naver.com</p>
        <button class="accept-btn">수락</button>
        <button class="refuse-btn">거절</button>
    </div>

    <div class="messenger-user-div m-received-bg">
        <div class="user-profile"><img src="/img/profile-img.png" alt=""></div>
        <p class="user-text">이이잉</p>
        <p class="user-text">gffds@naver.com</p>
        <button class="accept-btn">수락</button>
        <button class="refuse-btn">거절</button>
    </div>

    <div class="messenger-user-div m-request-bg">
        <div class="user-profile"><img src="/img/profile-img.png" alt=""></div>
        <p class="user-text">이이잉</p>
        <p class="user-text">fddefds@naver.com</p>
        <button class="request-cancle-btn">요청취소</button>
    </div>

    {{-- side title : 현재활동중 --}}
    <div class="m-side-title-div"><p class="m-side-title">현재활동중</p></div>
</div>
    </div>
</div>

{{-- 친구추가 모달 --}}
<div id="friend-Modal">
    <form id="friendRequestForm" action="{{ route('friend.sendFriendRequest') }}" method="post">
    @csrf
    <div class="friend-Modal-content">
        <div class="friend-Modal-header"><span class="f-r-modal-title">유저 이메일로 추가</span><button type="button" class="fclose-btn" onclick="fcloseModal()">X</button></div>
        <div class="friend-request-input-div">
            <input class="friend-request-input" type="email" name="receiver_email" id="receiver_email" autocomplete="off" placeholder="email로 추가">
            <button id="submitBtn" type="submit" class="add-button">+</button>
            <p class="request-messege">메세지 출력</p>
            {{-- 에러출력 --}}
            @if ($errors->has('receiver_email'))
            <div class="alert alert-danger">{{ $errors->first('receiver_email') }}</div>
            @endif
            <!-- 뷰에서 성공 메시지 출력 -->
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </>
    </div>
    </form>
</div>

<script src="/js/messenger.js"></script>
</body>
