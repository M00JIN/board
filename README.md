# 다목적 게시판
 사용 목적에 따라 수정이 가능한 기본 게시판입니다.


## 정보
- http://www.manduya.site
- Web hosting : AWS EC2
- Development environment : Windows 10
- Development language : HTML / CSS / JavaScript / PHP + Bootstrap 4 
- php version : 7.4.1
- Database : mysql 8.0.17

## 구성
### Libarary
---
**MYDB.php**  
데이터베이스 접속을 위한 함수 정의  
  
**title.php**  
로그인 창이 포함된 상단 고정 바  
### Login  
---  
**login_result.php**  
로그인 시도에 대한 결과 도출  
로그인한 클라이언트의 ip 값 db update        

**logout.php**  
접속 중인 계정에 대한 session 해제  

**multi_login.php**  
다른 클라이언트에서 접속 중인 계정으로 로그인 할 경우 메시지 출력 후 session 해제  



### Member
+ 회원가입 / 회원 정보 수정
+ 로그인 / 로그아웃
