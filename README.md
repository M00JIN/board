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
### Libarary
---
**MYDB.php**  
- 데이터베이스 접속을 위한 함수 정의  
  
**title.php**  
- 로그인 창이 포함된 상단 고정 바  
### Login  
---  
**login_result.php**  
- 로그인 시도에 대한 결과 도출  
- 로그인한 클라이언트의 ip 값 database 등록        

**logout.php**  
- 접속 중인 계정에 대한 세션 해제  

**multi_login.php**  
- 다른 클라이언트에서 접속 중인 계정으로 로그인 할 경우 메시지 출력 후 세션 해제  

### Member  
---
**insert_Form.php**  

