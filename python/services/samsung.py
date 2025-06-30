import time

import selenium
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

def samsung(cfg):

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
    driver.get(cfg.samsung_url)

    # 이름 입력
    common.WaitTimeOut(driver,'//*[@id="piboja-name"]', "visible").send_keys(name)

    # 주민등록번호 앞자리 입력
    common.WaitTimeOut(driver, '//*[@id="ssn1"]', "click").send_keys(rrno1)

    # 주민등록번호 뒷자리 입력
    common.WaitTimeOut(driver, '//*[@id="ssn2"]', "click").click()
    # 키패드 그룹이 나타날 때까지 기다립니다.
    keypad_group = common.WaitTimeOut(driver, "div.kpd-group.number", "load", "css")
    print("보안 키패드 그룹 확인 완료.")

    for digit in rrno2:
        number_button_xpath = f"//img[@class='kpd-data' and @alt='{digit}']"
        common.WaitTimeOut(keypad_group, number_button_xpath, "click").click()
        print(f"숫자 '{digit}' 버튼 클릭")

    # 확인 체크박스 클릭
    common.WaitTimeOut(driver, '//*[@id="form-ssnbox-normal"]/div[5]/label', "click").click()

    # 전체 동의 클릭
    common.WaitTimeOut(driver, '//*[@id="btn-all-agree"]', "visible").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="btn-confirm"]', "click").click()

    time.sleep(3)

    # 다음 페이지
    # 휴대폰 앞자리는 010으로 고정되어있음
    # 휴대폰 뒷자리 (8자리) 입력
    common.WaitTimeOut(driver, '//*[@id="phone-tel01"]', "visible").send_keys(phone_suffix)

    # 전체동의 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="form-auth-phone"]/div[3]/button', "click").click()

    # 인증번호 받기 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="form-auth-phone"]/div[6]/table/tbody/tr/td/div[1]/button', "click").click()

    time.sleep(3)

    # 인증번호 발송 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[11]/div/div/div/div/div[3]/button', "visible").click()

    # 인증번호 입력 필드 xpath = '//*[@id="form-auth-phone"]/div[6]/table/tbody/tr/td/div[2]/div[1]/div[2]/input'

    time.sleep(25)

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="ModuleUserCert2"]/div[2]/button[2]', "click").click()

    time.sleep(3)

    # 다음 페이지
    # 새로운 자동차 구매 클릭
    common.WaitTimeOut(driver, '//*[@id="car-list-type-start"]/div[3]/button', "load")
    common.WaitTimeOut(driver, '//*[@id="car-list-type-start"]/div[3]/button', "click").click()

    # 자동차 번호를 알고 있습니다 클릭
    common.WaitTimeOut(driver, '//*[@id="newcar-type-01"]', "visible").click()

    # 자동차 번호 입력
    common.WaitTimeOut(driver, '//*[@id="newcar-type-01"]/div[1]/div/div[2]/input', "visible").send_keys(car_number)

    # Todo: 보험 기간 설정 기능 추가 필요

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="btn-next-step"]', "click").click()

    time.sleep(3)

    # 다음 페이지
    # 장착 부속품 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button[2]', "visible").click()

    time.sleep(3)

    # 자동자 세부정보 확인 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="CarzenSingle"]/div/div/div[3]/button', "visible")
    common.WaitTimeOut(driver, '//*[@id="CarzenSingle"]/div/div/div[3]/button', "click").click()

    # 블랙박스 장착 예 클릭
    blackbox_yes = common.WaitTimeOut(driver ,'//*[@id="radio-blackbox"]/label[1]', "load")
    blackbox_yes.click()

    # 블랙박스 정보 입력
    blackbox_modal = common.WaitTimeOut(driver, '//*[@id="CarBlackboxDetail"]/div/div', "load")
    common.WaitTimeOut(blackbox_modal, '//*[@id="dropdown-year"]/div/button', "click").click()

    dropdown_menu_selector = "ul.sfd-dropdown-menu.dropdown-menu"

    # 드롭다운 메뉴가 보이는 상태가 될 때까지 기다립니다.
    common.WaitTimeOut(driver, dropdown_menu_selector, "visible", "css")
    print("드롭다운 메뉴가 표시되었습니다.")

    # data-value 속성을 사용하여 원하는 연도 항목을 찾습니다.
    # 구성된 선택자는 `ul.sfd-dropdown-menu.dropdown-menu li[data-value='2024'] a` 형태가 됩니다.
    target_item_selector = f"{dropdown_menu_selector} li[data-value='{blackbox_year}'] a"

    # 해당 항목이 클릭 가능할 때까지 기다린 후 클릭합니다.
    target_element = common.WaitTimeOut(driver, target_item_selector, "click", "css")
    target_element.click()
    print(f"'{blackbox_year}년' 항목이 성공적으로 클릭되었습니다.")

    # 블랙박스 가격 입력
    common.WaitTimeOut(blackbox_modal, '//*[@id="user-price"]', "click").send_keys(blackbox_price)

    # 블랙박스 정보 입력 확인 버튼 클릭
    common.WaitTimeOut(blackbox_modal, '//*[@id="btn-confirm"]', "click").click()

    # 블랙박스 사진 등록 모달 확인 클릭
    blackbox_picture_modal = common.WaitTimeOut(driver, '//*[@id="CommonAlert"]/div/div', "load")
    time.sleep(3)
    common.WaitTimeOut(blackbox_picture_modal, '/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button', "click").click()
    common.WaitTimeOut(blackbox_picture_modal, '/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button', "fade")

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="btn-next-step"]', "visible").click()

    time.sleep(5)

    # 다음 페이지
    # 운전자 선택
    # Todo: 운전자 별 선택 기능 추가 피룡
    common.WaitTimeOut(driver, '//*[@id="button-container"]/ul/li[1]/a', "visible")
    common.WaitTimeOut(driver, '//*[@id="button-container"]/ul/li[1]/a', "click").click()

    # 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="btn-next-step"]', "click").click()

    time.sleep(3)
    # 할인 특약 한번에 조회 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="btn-confirm"]', "visible").click()

    time.sleep(1)
    # 휴대폰 번호 입력
    common.WaitTimeOut(driver, '//*[@id="phone-num"]', "visible").send_keys(phone_suffix)

    time.sleep(3)
    # 제조사 차량 데이터 활용 전체동의 클릭
    common.WaitTimeOut(driver, '//*[@id="checkbox-agree"]/label', "click").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button', "visible").click()

    # 커넥티드 블랙박스 전체동의 클릭
    common.WaitTimeOut(driver, '//*[@id="checkbox-box-agree"]/label', "visible").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button', "visible").click()

    # 스크롤 제일 밑으로 내리기
    scroll_area = common.WaitTimeOut(driver, "__agree-area", "load", "class")
    # 자바스크립트를 실행하여 스크롤을 맨 아래로 내립니다.
    driver.execute_script("arguments[0].scrollTop = arguments[0].scrollHeight;", scroll_area)
    print("스크롤이 맨 아래로 이동했습니다.")
    # 스크롤이 적용될 시간을 잠시 기다릴 수 있습니다 (필요하다면)
    time.sleep(1)

    # T맵 전체동의 클릭
    common.WaitTimeOut(driver, '//*[@id="checkbox-tMap-agree"]/label', "visible").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button', "visible").click()

    # 윈터타이어 전체 동의 클릭
    common.WaitTimeOut(driver, '//*[@id="checkbox-winterTire-agree"]/label', "click").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button', "visible").click()

    # 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[11]/div/div/div/div/div[3]/button[2]', "visible").click()

    # 본인인증 이력 확인 버튼 클릭
    common.WaitTimeOut(driver, '/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button', "visible").click()

    # 로딩창 사라질때까지 대기
    try:
        loading_screen_selector = "div.loading-pop.type2"  # 정확한 CSS 선택자
        common.WaitTimeOut(driver, loading_screen_selector, "fade", "css")
        print("로딩창 사라짐")
    except TimeoutException:
        pass

    # 가입 가능 할인 특약 조회 안내 확인 버튼 클릭
    first_confirm_button_selector = "/html/body/div[2]/div[11]/div[2]/div/div/div/div[3]/button"
    first_confirm_button = common.WaitTimeOut(driver, first_confirm_button_selector, "click")
    first_confirm_button.click()
    print("첫 번째 팝업의 '확인' 버튼 클릭 성공.")

    common.WaitTimeOut(driver, first_confirm_button_selector, "fade")
    print("첫 번째 팝업이 사라졌습니다.")

    confirm_modal = common.WaitTimeOut(driver, '//*[@id="CommonAlert"]/div', "load")
    common.WaitTimeOut(confirm_modal, '/html/body/div[2]/div[11]/div/div/div/div/div[3]/button', "click").click()
    print("두 번째 팝업의 '확인' 버튼 클릭 성공.")

    # 두 번째 팝업도 사라질 때까지 기다립니다.
    common.WaitTimeOut(confirm_modal, '/html/body/div[2]/div[11]/div/div/div/div/div[3]/button', "fade")
    print("두 번째 팝업이 사라졌습니다.")

    # 할인 특약 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="btn-next-step"]', "click").click()

    # 마일리지 할인특약 안내 확인 버튼 클릭
    modal = common.WaitTimeOut(driver, '//*[@id="CarMileageOptionInfo"]/div/div', "load")
    common.WaitTimeOut(modal, '//*[@id="btn-confirm"]', "click").click()
    common.WaitTimeOut(modal, '//*[@id="btn-confirm"]', "fade")

    # 기타사항 다음 버튼 클릭
    common.WaitTimeOut(driver, '//*[@id="btn-next-step"]', "click").click()

    time.sleep(10)
    # 로딩창 사라질때까지 대기1
    try:
        loading = common.WaitTimeOut(driver, '//*[@id="loading-message-box"]/div', "load")
        print("로딩창 감지됨")
        common.WaitTimeOut(loading, '//*[@id="loading-message-box"]/div/div[1]', "fade")
        print("로딩창 사라짐")
    except TimeoutException:
        pass

    # 로딩창 사라질때까지 대기2
    try:
        loading = common.WaitTimeOut(driver, '//*[@id="loading-common"]/div', "load")
        print("로딩창 감지됨")
        common.WaitTimeOut(loading, '//*[@id="loading-common"]/div/div[1]', "fade")
        print("로딩창 사라짐")
    except TimeoutException:
        pass

    # Todo: 담보 설정 기능 추가 필요

    # 최종 보험료 추출
    text_element_selector = "div.total-premium strong.blind"
    text_element = common.WaitTimeOut(driver, text_element_selector, "load", "css")
    result = text_element.text.strip()

    print(f"추출된 텍스트: {result}")
