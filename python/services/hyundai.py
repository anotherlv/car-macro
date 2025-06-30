import time
from selenium import webdriver
from selenium.common import TimeoutException
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import Select
from webdriver_manager.chrome import ChromeDriverManager
import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))
from common_utils import CommonUtils
common = CommonUtils()
from selenium.webdriver.chrome.options import Options



def hyundai(cfg):

    # 임시 데이터
    name = cfg.api_data["name"]
    ssn = cfg.api_data["ssn"]
    phone = cfg.api_data["phone"]
    telecom = cfg.api_data["telecom"]
    car_number = cfg.api_data["car_num"]
    blackbox_year = cfg.api_data["blackbox_year"]
    blackbox_price = cfg.api_data["blackbox_price"]

    parts = ssn.split('-')
    rrno1 = parts[0]
    rrno2 = parts[1]

    # 앞에 세 자리 분리
    phone_prefix = phone[:3]
    # 나머지 뒷자리 분리
    phone_suffix = phone[3:]
    # 휴대전화 중간 자리
    phone_middle = phone_suffix[:4]
    # 휴대전화 마지막 자리
    phone_last = phone_suffix[4:]

    mobile_user_agent = "Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1"
    options = Options()

    # 1. 모바일 에뮬레이션 설정 (핵심!)
    # 이 옵션이 device toolbar 기능을 Selenium에서 직접 구현하는 방법입니다.
    mobile_emulation = {"deviceName": "iPhone X"}
    options.add_experimental_option("mobileEmulation", mobile_emulation)
    print(f"**모바일 디바이스 에뮬레이션 설정 완료**")

    options.add_argument(f"user-agent={mobile_user_agent}")
    # options.add_argument("--disable-blink-features=AutomationControlled")  # 일부 봇 감지 우회
    # options.add_argument("--disable-infobars")  # "Chrome이 자동화된 테스트 소프트웨어에 의해 제어됩니다" 메시지 숨김
    # options.add_argument('--disable-blink-features=AutomationControlled') # DevTools Protocol을 사용하여 navigator.webdriver 속성을 false로 변경
    # options.add_experimental_option("excludeSwitches", ["enable-automation"])  # 자동화 배너 제거
    # options.add_experimental_option("useAutomationExtension", False)  # 자동화 확장 프로그램 비활성화

    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service= service, options=options)

    # # JavaScript를 사용하여 navigator.webdriver 속성을 다시 정의 (더 강력한 방법)
    # driver.execute_cdp_cmd('Page.addScriptToEvaluateOnNewDocument', {
    #     'source': '''
    #             Object.defineProperty(navigator, 'webdriver', {
    #                 get: () => undefined
    #             })
    #         '''
    # })

    driver.get(cfg.hyundai_url)

    # 오늘 그만보기 알럿창 닫기
    try:
        common.WaitTimeOut(driver, "/html/body/div[4]/div/div/div[2]/div/button[1]", "load").click()
    except TimeoutException:
        pass

    # 이름 입력
    common.WaitTimeOut(driver, '/html/body/div[1]/div[4]/div/div[1]/div/form/fieldset/div/div[2]/div/div/div[1]/div[2]/input', "click").send_keys(name)

    # 주민등록번호 앞자리 입력
    common.WaitTimeOut(driver, '/html/body/div[1]/div[4]/div/div[1]/div/form/fieldset/div/div[2]/div/div/div[2]/div[2]/input', "click").send_keys(rrno1)

    # 주민등록번호 뒷자리 입력
    common.WaitTimeOut(driver, '//*[@id="xk-pad"]', "visible")
    print("가상 키패드 컨테이너 확인 완료.")

    # time.sleep(3)
    # 주민번호 뒷자리의 각 숫자를 순서대로 입력
    for i, digit in enumerate(rrno2):
        digit_button_xpath = f'//*[@id="xk-pad"]//a[./em[text()="{digit}"] and contains(@class, "xknumber")]'

        common.WaitTimeOut(driver, digit_button_xpath, "click").click()
        print(f"[{i + 1}/{len(rrno2)}] 숫자 '{digit}' 클릭 완료.")

        time.sleep(0.1)  # 키패드 애니메이션이나 내부 로직 처리를 위한 짧은 대기

    # 휴대폰 앞자리 선택
    select_web_element = common.WaitTimeOut(driver, "telNo_bf", "load", "id")

    # Select 객체를 생성
    select_obj = Select(select_web_element)

    # 텍스트 값으로 옵션을 선택
    select_obj.select_by_visible_text(phone_prefix)

    # 휴대폰 뒷자리 입력
    common.WaitTimeOut(driver, '/html/body/div[1]/div[4]/div/div[1]/div/form/fieldset/div/div[2]/div/div/div[3]/div/div[3]/input[1]', "click").send_keys(phone_suffix)

    # 전체 동의 클릭
    common.WaitTimeOut(driver, '/html/body/div[82]/div/div/div[1]/div/div/div[2]/a', "visible").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver,'/html/body/div[84]/div/div/div[3]/div/button', "visible").click()

    # 가입설계를 위한 개인 정보 처리 동의
    common.WaitTimeOut(driver, '/html/body/div[84]/div/div/div[3]/div/button', "visible").click()

    # 가입설계를 위한 개인 정보 처리 동의2
    common.WaitTimeOut(driver, '/html/body/div[84]/div/div/div[3]/div/button', "visible").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[82]/div/div/div[2]/div/button', "visible").click()

    # 다음 페이지
    # 본인인증 방식 선택 (휴대폰인증)
    common.WaitTimeOut(driver, '/html/body/div[58]/div/div/div[2]/div/div/div[2]/div/div[4]/button', "visible").click()

    # 통신사 선택
    telecom_select_element = common.WaitTimeOut(driver, "mvComeanCat", "click", "id")

    # Select 객체 생성
    select = Select(telecom_select_element)

    # 옵션 텍스트를 순회하며 일치하는 통신사를 찾습니다.
    normalized_telecom = telecom.upper().replace("LGU+", "LG U+")   # LGU+같은 경우 띄어쓰기 상태로 변경
    found = False
    for option in select.options:
        if option.text.strip().upper() == normalized_telecom:
            select.select_by_visible_text(option.text)
            found = True
            print(f"통신사 '{telecom}'에 해당하는 옵션 '{option.text}' 선택 완료.")
            break

    if not found:
        if not found:
            print(f"경고: 통신사 '{telecom}'에 해당하는 옵션을 찾을 수 없습니다.")

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[74]/div/div/div[3]/div[1]/button', "click").click()

    # 휴대폰 인증 개인정보처리 상세 동의 전체동의 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[76]/div/div/div[1]/div[1]/div/div[2]/a', "visible").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[76]/div/div/div[2]/div/button', "visible").click()

    # 인증번호 발송 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[8]/div/div/div[3]/div/button', "visible").click()

    time.sleep(25)

    # 인증확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[83]/div/div/div[3]/div/button', "click").click()

    # 인증 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[8]/div/div/div[3]/div/button', "visible").click()

    # 보험료 새로 계산하기 클릭 (이미 계산 내역이 있을경우)
    is_calculated = False
    try:
        common.WaitTimeOut(driver, '//*[@id="MTPC0131G"]/div/div/div[3]/div/button', "visible").click()
        is_calculated = True
    except TimeoutException:
        pass

    # 신규 가입 버튼 클릭
    # Todo: 자동차 보험이 가입되어 있지 않은 고객 상대로는 다른 루트 작성 필요 (현재는 이미 가입된 유저 기반으로 작성됨)
    try:
        common.WaitTimeOut(driver, '/html/body/div[20]/section/div[3]/div/a', "visible").click()
    except TimeoutException:
        pass

    # 차량번호 입력
    common.WaitTimeOut(driver, '/html/body/div[3]/form/section[1]/div[2]/fieldset/div/input', "visible").send_keys(car_number)

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[3]/form/div/span[2]/a', "click").click()

    # 차종 선택 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[37]/div/div[2]/a', "visible").click()

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[3]/form/div/span[2]/a', "click").click()

    # 일치 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[3]/div[6]/div/div[2]/span[2]/a', "visible").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[17]/div/div/span/a', "visible").click()

    # 블랙박스 장착 "예" 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[3]/form/section/div[3]/div[1]/a', "visible").click()

    # 블랙박스 장착 연도 선택
    year_select_element = common.WaitTimeOut(driver, "selectY0", "click", "id")
    select = Select(year_select_element)
    select.select_by_value(str(blackbox_year))  # blackbox_year가 정수일 경우를 대비해 str로 변환

    # 블랙박스 금액 입력
    common.WaitTimeOut(driver, '/html/body/div[4]/div/div[1]/fieldset/div[2]/input[1]', "click").send_keys(blackbox_price)

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[4]/div/div[2]/span[2]/a', "click").click()

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[3]/div[3]/span[2]/a', "visible").click()

    # 운전자 선택
    # Todo: 보험 가입 운전자 선택 기능 추가 필요
    common.WaitTimeOut(driver, '/html/body/div[3]/section[1]/div[2]/ul/li[1]/a', "visible").click()

    # 보험료 확인하기 클릭
    common.WaitTimeOut(driver, '/html/body/div[3]/font/div[2]/span[2]/a', "click").click()

    # 해당 보험사 보험 계산 이력 없을 경우
    if not is_calculated:
        # 마일리지 특약 가입 확인 버튼 클릭
        common.WaitTimeOut(driver, '/html/body/c:set/c:set/div[110]/div/div[2]/span[2]/a', "visible").click()

        # 확인 버튼 클릭
        common.WaitTimeOut(driver, '/html/body/c:set/c:set/div[4]/div/div/div[2]/span[2]/a', "visible").click()

        # 현대차/기아 데이터 활용을 위한 개인 정보처리 상세 동의 전체동의 버튼 클릭
        common.WaitTimeOut(driver, '/html/body/c:set/c:set/div[40]/div[1]/div[3]/section/div[2]/div/a', "visible").click()

        # 안전운전할인특약 가입 확인 전체동의 버튼 클릭
        common.WaitTimeOut(driver, '/html/body/c:set/c:set/div[40]/div[1]/div[4]/section/div[2]/div/a', "click").click()

        # 커넥티드 블랙박스 전체동의 버튼 클릭
        common.WaitTimeOut(driver, '/html/body/c:set/c:set/div[40]/div[1]/div[5]/section/div[2]/div/a', "click").click()

    # 할인 특약 조회 결과 확인 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="allSafeDrvInfoLayer"]/div/div/a', "visible").click()

    # Todo: 자녀할인, 첨단안전장치 할인특약 hud 할인 특약 가입여부 선택, 담보 설정 기능 추가 필요

    # 총 결제 보험료 추출
    result = common.WaitTimeOut(driver, '//*[@id="totalAmt"]', "visible").text
    print(result)

    # driver.quit()
    # return result
