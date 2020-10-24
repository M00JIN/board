# 다목적 게시판
 사용 목적에 따라 수정이 가능한 기본 게시판입니다. + 프로젝트 계획 이유


## 정보
- http://www.manduya.site
- 웹 호스팅 : AWS EC2
- 개발 환경 : Windows 10
- 개발 언어 : HTML / CSS / JavaScript / PHP + Bootstrap 4 
- php 버전 : 7.4.1
- 데이터베이스 : mysql 8.0.17

## 구성
### [ Libarary ]  

**MYDB.php**  
- 데이터베이스 접속을 위한 함수 정의  
  
**title.php**  
- 로그인 창이 포함된 상단 고정 바  

---

### [ Login ]  

**login_result.php**  
- 로그인 시도에 대한 결과 도출  
- 로그인한 클라이언트의 ip 값 database 등록        

**logout.php**  
- 접속 중인 계정에 대한 세션 해제  

**multi_login.php**  
- 다른 클라이언트에서 접속 중인 계정으로 로그인 할 경우 메시지 출력 후 세션 해제  
---  
### [ Member ]  

**insertForm.php**  
- 회원 가입을 위한 정보 입력 폼  
- 필수 입력 항목 유효성 검사  

**check_id.php**  
- 아이디 유효성 검사  
- 아이디 중복 검사  

**check_nick.php**  
- 닉네임 중복 검사  

**insertPro.php**  
- 패스워드 유효성 검사
- 이메일 유효성 검사  
- 패스워드 해싱  
- 회원정보 database 등록  

**updateForm_check.php**  
- 회원정보 수정을 위한 패스워드 입력  


**updateForm.php**  
- 회원정보 수정 폼  

**updatePro.php**  
- 닉네임 중복 검사  
- 수정된 회원정보 db 등록  

**change_pass.php**  
- 변경할 패스워드 입력 / 확인 절차  
- URL 조작을 통한 다른 계정의 패스워드 변경 차단  

**change_pass_confirm.php**  
- 변경할 패스워드 유효성 검사  
- 패스워드 해싱  
- 변경한 패스워드 database 등록  
---  
### [ Text_board ]  
**list.php**  
- database에 등록된 게시물 출력 / 이미지가 업로드되어 있을 경우 썸네일 출력  
- 공지사항 / 비공지사항 구분 
- 새 게시물 등록 시 48시간동안 New 표시  
- 게시물 등록 시각이 24시간 이내인 경우 날짜 대신 시각으로 표시  
- 페이징 처리  

**write_form.php**  
- 게시물 작성 폼  
- "admin" 계정으로 작성할 경우 공지사항으로 등록 가능  

![capture](https://user-images.githubusercontent.com/44194202/97080163-672c5080-1634-11eb-8cab-f584d0704e0c.png)  


- 네이버 스마트에디터 연동  
- 이미지 파일 업로드 가능  

**modify_form.php**  
- 수정할 게시물 내용 호출  
- 공지사항 등록 여부  
- 첨부 파일 여부 / 삭제 기능 활성화  


**insert.php**  
- 다음 과정을 거쳐 database 등록 :  

1. 처음 등록하는 게시물일 경우  

공지사항 등록 여부 검사  
업로드할 파일 유효성 검사  
업로드  

2. 등록되어 있는 게시물을 수정할 경우  

공지사항 등록 여부 검사  
첨부 파일에 대한 삭제 여부 확인  
추가로 업로드할 파일 정보 처리  
업로드  

**delete.php**  
- 선택한 게시물 database에서 delete  

**view.php**  
- 등록된 게시물 내용 표시  
- 이미지 사이즈 자동 조정  
- 목록 / 수정 / 삭제 / 글쓰기 버튼 활성화  
- 쿠키를 이용한 조회수 제한 (24시간동안 1 초과 불가능)  
- 댓글 기능 활성화 - 조회 / 삭제 / 등록  

**insert_ripple.php**  
- 해당 게시물에 대한 댓글 등록 처리  

**delete_ripple.php**  
- 게시물 번호, 댓글 번호와 일치하는 댓글 삭제  

---  
+
