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

def meritz(cfg):

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

    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service=service)
    driver.get(cfg.meritz_url)

    target_frame = None
    iframes = driver.find_elements(By.TAG_NAME, "iframe")
    for iframe in iframes:
        try:
            # iframe의 src 속성을 확인하여 "contract.do" 포함 여부 검사
            iframe_src = iframe.get_attribute("src")
            if iframe_src and "contract.do" in iframe_src:
                target_frame = iframe
                break
        except Exception as e:
            print(f"iframe src 속성 확인 중 오류: {e}")
            continue

    if not target_frame:
        print("iframe을 찾을 수 없습니다.")
        return

    # iframe으로 전환
    driver.switch_to.frame(target_frame)
    print("iframe으로 전환 완료.")

    # 이름 입력
    common.WaitTimeOut(driver, '//*[@id="rsName"]', "load").send_keys(name)

    # 주민번호 앞자리 입력
    driver.find_element(By.XPATH, '//*[@id="rsIdNo1"]').send_keys(rrno1)
    time.sleep(5)  # Playwright의 delay=100과 유사

    # 키패드 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="frmAth"]/div[2]/div/div[3]/a', "load").click()

    # 키패드가 뜰 시간 대기
    common.WaitTimeOut(driver, "transkey_numberMainDiv", "load", "class")
    print("키패드가 정상적으로 떴습니다.")

    # 주민번호 뒷자리 입력 (키패드 클릭)
    for digit in rrno2:
        common.WaitTimeOut(driver, f"a[aria-label='{digit}']", "click", "css").click()
        time.sleep(0.1)

    # Todo: 현재는 전화번호 앞자리 010 고정. 추후 앞자리 선택 기능 추가 필요
    # 전화번호 입력 (010 제외)
    common.WaitTimeOut(driver, '//*[@id="txtMobil"]', "click").send_keys(phone_suffix)

    # 동의 체크박스 클릭
    common.WaitTimeOut(driver, '//*[@id="frmAth"]/div[4]/dl/dd[2]/div/div/div', "click").click()

    # 전체 동의 클릭
    common.WaitTimeOut(driver, '//*[@id="insperAgreePopNew"]/div/div[2]/div/div/article[1]/div[2]/div[1]/div/div/div[1]/div/div[2]/article/div', "click").click()

    time.sleep(1)
    # 확인 클릭
    common.WaitTimeOut(driver, '//*[@id="btnAgreeOk"]', "load").click()

    # 올해 내 차 보험료 계산하기 클릭
    common.WaitTimeOut(driver, '//*[@id="pn_container"]/div/div[6]/div/a', "click").click()

    #############
    # 다음 페이지 #
    #############

    time.sleep(3)

    try:
        common.WaitTimeOut(driver, '//*[@id="layerConfirm"]/div/div/a[1]', "click").click()
    except TimeoutException:
        pass

    # 통신사 선택 클릭
    common.WaitTimeOut(driver, '//*[@id="pn_container"]/div/div[3]/div[2]/div[1]/div/div[3]/div', "click").click()

    # 해당하는 통신사 클릭
    common.WaitTimeOut(driver, f"//ul[@class='slc_drop']/li/a[text()='{telecom}']", "click").click()

    # 전체동의 및 인증번호 받기 클릭
    common.WaitTimeOut(driver, '//*[@id="pn_container"]/div/div[3]/div[2]/div[1]/div/div[5]/div[1]/a', "click").click()

    # 인증번호 발송 알럿창 확인 클릭
    common.WaitTimeOut(driver, '//*[@id="layerAlert"]/div/div/a', "click").click()

    # 인증번호 입력시간 대기
    time.sleep(25)

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="pn_container"]/div/div[6]/div/a[2]', "click").click()

    #############
    # 다음 페이지 #
    #############

    time.sleep(5)

    # 차량번호 클릭
    common.WaitTimeOut(driver, '//*[@id="pn_container"]/div/div[3]/div[2]/div[1]/div[2]/div/div[1]/div/div[2]', "click").click()

    # 차량번호 입력
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[3]/div[2]/div[1]/div[2]/div/div[2]/div[2]/div[1]/div/input', "click").send_keys(car_number)

    # 보험 시작일 입력
    # Todo: 보험 종료일이 따로 있을 경우 추가 기능 필요
    # start_date = "20250620"
    # common.WaitTimeOut(driver, '//*[@id="ra022"]', "click").clear()
    # common.WaitTimeOut(driver, '//*[@id="ra022"]', "click").send_keys(start_date)

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="pn_container"]/div/div[6]/div/a[2]', "click").click()

    #############
    # 다음 페이지 #
    #############

    # 명의이전예정 클릭
    common.WaitTimeOut(driver, '//*[@id="pop_vehcRegOwnrCnss"]/div[2]/article/div[2]/div[1]/div[2]/div[2]/div/div/div/div[3]', "click").click()

    # 확인 클릭
    common.WaitTimeOut(driver, '//*[@id="btnAgreeOk"]', "click").click()

    time.sleep(5)
    # 일반설계 클릭
    common.WaitTimeOut(driver, '//*[@id="btnAgreeOk"]', "click").click()

    time.sleep(1)
    # 내 자동차 정보가 맞습니다 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[4]/div/div[2]/div[2]/div/a[1]', "click").click()

    time.sleep(1)
    # 적용하기 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[4]/div/div[2]/div/div[2]/div[2]/button[2]', "click").click()

    time.sleep(1)
    # 다음 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[6]/div/a[2]', "click").click()

    #############
    # 다음 페이지 #
    #############

    time.sleep(5)

    # Todo: 추후 운전자 선택 기능 추가 필요
    # 자동차 소유자 1인 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[3]/div[2]/div[1]/div/div/div[1]/div/div/div[1]/div[1]/div', "click").click()

    # 자녀할인 아니요 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[3]/div[2]/div[1]/div/div/div[3]/div[1]/div[1]/div/div[2]', "click").click()

    # 다음 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[6]/div/a[2]', "click").click()

    #############
    # 다음 페이지 #
    #############

    time.sleep(5)

    # 알림창 확인 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[4]/div/div/div/a', "click").click()

    time.sleep(3)
    # UBI안전운전할인 특약 아니요 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[3]/div[2]/div[1]/div[2]/div/div/div/button[2]', "click").click()

    # 다음 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[6]/div/a[2]', "click").click()

    #############
    # 다음 페이지 #
    #############

    time.sleep(5)

    # 알림창 확인 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[3]/div[2]/div[5]/div/div[3]/button', "click").click()

    # Todo: 담보 설정 기능 추가 필요

    # 블랙박스장치특약 체크박스 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[3]/div[2]/div[2]/div[1]/div[1]/div/div/div/div/div/div[1]/div[5]/a[1]', "click").click()

    # 블랙박스 장치 특약 체크
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[4]/div/div/div[2]/div/div/article/div/div[1]/div/div[1]/div[2]/div[1]/div/div/div', "click").click()

    time.sleep(1)

    # 블랙박스 구입 연도 / 가격 입력
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[4]/div/div/div[2]/div/div/article/div/div[1]/div/div[1]/div[2]/div[2]/div/div/div/div[1]/input', "click").send_keys(blackbox_year)
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[4]/div/div/div[2]/div/div/article/div/div[1]/div/div[1]/div[2]/div[2]/div/div/div/div[2]/input', "click").send_keys(blackbox_price)

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[4]/div/div/div[2]/div/div/article/div/div[1]/div/div[3]/a[2]', "click").click()

    time.sleep(5)

    # 계산된 보험료 추출
    price = common.WaitTimeOut(driver, "resultVal", "load", "id")
    price = price.text
    print(price)
    # driver.quit()
    # return price

    # 가입하기 버튼 클릭
    # common.WaitTimeOut(driver, '/html/body/div[2]/div[2]/div/div[6]/div/a[2]', "click").click()
