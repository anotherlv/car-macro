import time
from selenium import webdriver
from selenium.common import TimeoutException
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))
from common_utils import CommonUtils
common = CommonUtils()

def kb(cfg):

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

    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service=service)
    driver.get(cfg.kb_url)

    # 이름 입력
    common.WaitTimeOut(driver, '//*[@id="userName"]', "load").send_keys(name)

    # 주민번호 앞자리 입력
    driver.find_element(By.XPATH, '//*[@id="ibrgno1"]').send_keys(rrno1)
    common.Find(driver, '//*[@id="ibrgno1"]').send_keys(rrno1)

    # 주민번호 뒷자리 입력
    common.WaitTimeOut(driver, '//*[@id="ibrgno2"]', "load")
    print("가상 키패드 컨테이너 확인 완료.")

    # 주민번호 뒷자리의 각 숫자를 순서대로 입력
    for digit in rrno2:
        digit_xpath = f"//div[@id='mtk_ibrgno2']//img[@alt='{digit}']"
        common.WaitTimeOut(driver, digit_xpath, "click").click()
        time.sleep(0.1)

    # 휴대폰 앞자리 선택
    common.WaitTimeOut(driver, '//*[@id="conadrAreaNo_focus"]', "click").click()
    print("휴대폰 번호 앞자리 드롭다운 버튼 클릭 완료.")

    common.WaitTimeOut(driver, f'//*[@id="selectDrop0"]//ul/li/a[text()="{phone_prefix}"]', "click").click()
    print(f"휴대폰 앞자리 '{phone_prefix}' 선택 완료.")

    # 휴대폰 중간자리, 뒷자리 입력
    common.WaitTimeOut(driver, '//*[@id="conadrExchNo"]', "click").send_keys(phone_middle)
    common.WaitTimeOut(driver, '//*[@id="conadrSeq"]', "click").send_keys(phone_last)

    # 보험료 계산하기 클릭
    common.WaitTimeOut(driver, '//*[@id="ng-app"]/body/div[3]/div[3]/div/div[2]/div/div[4]/a[2]', "click").click()

    time.sleep(5)
    # 다음 페이지
    # 전체 동의 체크박스 클릭
    common.WaitTimeOut(driver, '//*[@id="all_check1_focus"]', "click").click()

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="ng-app"]/body/div[3]/div[3]/div/div[2]/div/div[4]/a[2]', "click").click()

    time.sleep(5)
    # 본인인증 전체 동의 체크박스 클릭
    common.WaitTimeOut(driver, '//*[@id="all_check0_focus"]', "click").click()

    # 통신사 선택 드랍다운 클릭
    common.WaitTimeOut(driver, '//*[@id="movComcoCd_focus"]', "click").click()

    # 통신사 클릭
    # kb 사이트에 작성된 통신사 형식에 맞게 변환
    if telecom == "LGU+":
        telecom = "LG U+"
    common.WaitTimeOut(driver, f'//div[@class="select_inner" and @tabindex="0"]/ul/li/a[text()="{telecom}"]', "click").click()
    print(f"통신사 '{telecom}' 선택 완료.")

    # 인증번호 전송 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="transPosi"]/div[2]/div[1]/div[2]/form/table/tbody/tr[2]/td/a', "click").click()

    # 알림창 확인 클릭
    common.WaitTimeOut(driver, '/html/body/div[7]/div[2]/div/div[2]/a', "click").click()

    time.sleep(25)
    # 본인인증 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="transPosi"]/div[2]/div[1]/div[3]/a', "click").click()

    time.sleep(3)
    # 최근 계산 내역 알림창 보험료 계산 새로 시작하기 버튼 클릭
    try:
        common.WaitTimeOut(driver, '/html/body/div[6]/div[2]/div/div/div/div[3]/a', "load")
        common.WaitTimeOut(driver, '/html/body/div[6]/div[2]/div/div/div/div[3]/a', "click").click()
    except TimeoutException:
        pass

    time.sleep(5)
    # 다음 페이지
    # 자동차 번호 입력
    common.WaitTimeOut(driver, '//*[@id="vehclnoHnglNm"]', "click").send_keys(car_number)

    # Todo: 보험 기간 설정 기능 추가 필요

    time.sleep(5)
    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="ng-app"]/body/div[3]/div[3]/div/div[2]/div/div[4]/a[2]', "click").click()

    # 부속품 장착 확인 버튼 클릭1
    try:
        time.sleep(5)
        common.WaitTimeOut(driver, '/html/body/div[32]/div[2]/div/div/div[3]/a', "click").click()
    except TimeoutException:
        pass

    # 다음 페이지
    # 부속품 장착 확인 버튼 클릭2
    try:
        time.sleep(5)
        common.WaitTimeOut(driver, '/html/body/div[32]/div[2]/div/div[2]/a', "click").click()
    except TimeoutException:
        pass

    time.sleep(5)
    # 현대/기아/케이지 차량 데이터 활용을 위한 개인 정보 처리 동의 전체 동의 체크박스 클릭
    common.WaitTimeOut(driver, '//*[@id="all_check1_focus"]', "click").click()

    time.sleep(5)
    # 차량데이터 조회하기 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[32]/div[2]/div/div/div/form/div/div[5]/a', "click").click()

    time.sleep(5)
    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[32]/div[2]/div/div/div/div/div[5]/a', "click").click()

    time.sleep(5)
    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="ng-app"]/body/div[3]/div[3]/div/div[2]/div/div[4]/a[2]', "click").click()

    time.sleep(5)
    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[3]/div[3]/div/div[2]/div/div[4]/a[2]', "click").click()

    time.sleep(5)
    # 다음 페이지
    # 운전자 선택
    # Todo: 운전자 별 선택 기능 추가 필요
    common.WaitTimeOut(driver, '//*[@id="radioStyle0"]', "click").click()

    time.sleep(5)
    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="ng-app"]/body/div[3]/div[3]/div/div[2]/div/div[4]/a[2]', "click").click()

    time.sleep(5)
    # KB의 할인특약을 확인하세요! 페이지에서 바로 다음 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[3]/div[3]/div/div[2]/div/div[4]/a[2]', "click").click()

    time.sleep(5)
    # 계약 후 할인 가능 안내 알림창 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[46]/div[2]/div/div/div/div[2]/a', "click").click()

    time.sleep(10)
    # 다음 페이지
    # 전기차 알림창 확인 버튼 클릭
    try:
        common.WaitTimeOut(driver, '/html/body/div[61]/div[2]/div/div[2]/a', "click").click()
    except TimeoutException:
        pass

    # Todo: 담보 설정 기능 추가 필요

    time.sleep(5)
    # 최종 보험료 추출
    amount_element = common.WaitTimeOut(driver, "//span[@class='name'][text()='다이렉트 보험료']/following-sibling::span[@class='cost']/strong", "load")
    amount_text = amount_element.text

    print(f"추출된 금액 텍스트: {amount_text}")

    # 텍스트에서 콤마(,)와 '원'을 제거하고 숫자로 변환합니다.
    cleaned_amount_text = amount_text.replace(",", "").strip('원')
    amount_value = int(cleaned_amount_text)
    print(f"숫자 값으로 변환된 금액: {amount_value}")

    # driver.quit()
    # return amount_text