import time
from selenium import webdriver
from selenium.common import TimeoutException
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))
from common_utils import CommonUtils
common = CommonUtils()

def directdb(cfg):
    auth_number = common.getAuthNumber(cfg)
    print(auth_number)

    return
    data = common.setData(cfg)
    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service=service)
    driver.get(cfg.directdb_url)

    # 이름 / 주민등록번호 / 전화번호 입력
    name_input = common.waitTimeOut(driver, '//*[@id="custNm"]', "click")
    name_input.send_keys(data["name"])

    rrno1_input = common.waitTimeOut(driver, '//*[@id="custRrno1"]', "click")
    rrno1_input.send_keys(data["rrno_1"])
    rrno1_input.send_keys(Keys.TAB)

    # 주민등록번호 뒷 7자리 가상 키패드 입력
    for num in data["rrno_2"]:
        selector = f'img.kpd-data[aria-label="{num}"]'
        keypad_digit_element = common.waitTimeOut(driver, selector, "click", "css")
        keypad_digit_element.click()
        time.sleep(0.1)

    # 전화번호 입력
    phone_number_input = common.waitTimeOut(driver, '//*[@id="clpNo"]', "click")
    phone_number_input.send_keys(data["phone_2"])

    next_button = common.waitTimeOut(driver, '//*[@id="nextBtnId"]', "click")
    next_button.click()


    #############
    # 다음 페이지 #
    #############

    # 고객정보 동의 모달이 나타날 때까지 기다림
    modal_element = common.waitTimeOut(driver, '//*[@id="divPopup-inner"]', "load")

    # '모두 동의' 체크박스 클릭 (필수 동의 모두 체크)
    all_agree_checkbox = common.waitTimeOut(driver, '//*[@id="persAllAgree"]', "click")
    all_agree_checkbox.click()

    pop_agree_button = common.waitTimeOut(driver, '//*[@id="btn_popAgree"]', "click")
    pop_agree_button.click()
    time.sleep(1)
    pop_agree_button.click()
    time.sleep(1)

    # 'btn_popAgree' 버튼이 사라질 때까지 기다림
    common.waitTimeOut(driver, '//*[@id="btn_popAgree"]', "fade")
    common.find(driver, '//*[@id="btnCustifCsnNext"]').click()
    common.find(driver, '//*[@id="prdCollectDisAgree"]').click()
    common.find(driver, '//*[@id="btnCustifCsnNext"]').click()

    # 본인인증 팝업이 나타날 때까지 기다림
    common.waitTimeOut(driver, "popup-inner", "load", "class")
    # id가 'cmBlockSreen'인 로딩 오버레이가 사라질 때까지 최대 10초 대기
    common.waitTimeOut(driver, '//*[@id="cmBlockSreen"]', "fade")

    # 통신사 드롭다운을 펼치는 버튼 클릭
    telecom_dropdown_button = common.waitTimeOut(driver, '//*[@id="sel_cpCorp"]/button', "click")
    telecom_dropdown_button.click()

    # 'LGU+' 옵션 버튼 찾기 및 클릭
    # Todo: 통신사 별 케이스 문 생성하여 유동적으로 처리 필요
    lguplus_option = common.waitTimeOut(driver, "//div[@class='inp-select-list']/ul/li/button[text()='{}']".format(data["telecom"]), "click")
    lguplus_option.click()
    time.sleep(0.5)
    common.find(driver, '//*[@id="__all_cp_agree__auth_form_layer"]').click()

    common.waitTimeOut(driver, '//*[@id="auth_form_layer"]/div/div', "load")

    scroll_button = common.waitTimeOut(driver, '//*[@id="btn_cp_confirm_all"]', "click")
    scroll_button.click()
    time.sleep(1)
    scroll_button.click()
    time.sleep(1)

    common.find(driver, '//*[@id="__requestCpAuthNo__"]').click()

    alert_popup_wrapper = common.waitTimeOut(driver, '//*[@id="cmLayerAlert"]', "load")
    confirm_button = common.waitTimeOut(alert_popup_wrapper, '//*[@id="cmAlertCheck"]', "click")
    confirm_button.click()

    common.waitTimeOut(driver, '//*[@id="cmLayerAlert"]', "fade")

    # Todo: 현재는 수동으로 웹페이지에 수신된 인증번호 입력하도록 되어있음. 추후 웹서버로 요청을 보내 받은 응답값을 넣도록 수정 작업 필요
    auth_number = common.getAuthNumber(cfg)
    auth_number_input = common.waitTimeOut(driver, '//*[@id="smsAuthNo"]', "click")
    auth_number_input.send_keys(auth_number)
    common.find(driver, '//*[@id="auth_form_layerDoAuth"]').click()


    #############
    # 다음 페이지 #
    #############

    # 자동차번호 라디오 버튼 클릭
    car_num_button = common.waitTimeOut(driver, '//*[@id="content"]/div/section/div/div[2]/div[2]/div[2]/div[1]/label', "click")
    car_num_button.click()

    # 차량 번호 입력
    common.find(driver, '//*[@id="inpHnglVhNo"]').send_keys("291러5414")

    # 보험 기간 시작일 입력
    # Todo: 시작일 입력시 기간이 1년 자동 설정되는데 혹시 1년 이상으로 설정해야될 경우 종료일 추가 입력 작업 필요
    common.find(driver, '//*[@id="inpArcTrmStrDt"]').clear()
    common.find(driver, '//*[@id="inpArcTrmStrDt"]').send_keys("20250625")
    common.find(driver, '//*[@id="btnNext"]').click()

    #############
    # 다음 페이지 #
    #############

    # 차량 옵션 선택
    # Todo: 현재는 무조건 첫번째 옵션값 선택 고정. 추후 실제 옵션 선택 기능 추가 필요 (마스터 DB에서 옵션 값 넘겨주는지 확인 필요)
    car_option_button = common.waitTimeOut(driver, '//*[@id="selectCarItem"]/div/table/tbody/tr[1]/td/div[1]/label', "click")

    car_option_button.click()
    common.find(driver, '//*[@id="btnNext1"]').click()


    #############
    # 다음 페이지 #
    #############
    try:
        target_button = common.waitTimeOut(driver, '//*[@id="mafrCpntInfoPop2"]/div/div/div[3]/div/button', "click")
        # WebDriverWait(driver, 2).until(EC.element_to_be_clickable(target_button)).click()
        # common.waitTimeOut(driver, '//*[@id="mafrCpntInfoPop2"]/div/div/div[3]/div/button', "load").click()
        target_button.click()
    except TimeoutException:
        pass

    try:
        alert_ok_button1 = common.waitTimeOut(driver, '//*[@id="popConnCarubiLayer"]/div/div/div[3]/div/button', "click")
        alert_ok_button1.click()
    except TimeoutException:
        pass

    try:
        alert_ok_button2 = common.waitTimeOut(driver, '//*[@id="mafrCpntInfoCmpltPop"]/div/div/div[3]/div/button', "click")
        alert_ok_button2.click()
    except TimeoutException:
        pass

    alert_ok_button3 = common.waitTimeOut(driver, '//*[@id="msgPushLayer0"]/div/div/div[3]/div/button', "click")
    alert_ok_button3.click()

    blackbox_button = common.waitTimeOut(driver, '//*[@id="blackbox"]/label', "click")
    blackbox_button.click()

    blackbox_year_select_button = common.waitTimeOut(driver, '//*[@id="purdate_black_box-inp-group"]/button', "click")
    blackbox_year_select_button.click()

    common.waitTimeOut(driver, "inp-select-list", "load", "class")

    # ul 내부에 있는 button 요소 중 텍스트가 target_year와 동일한 요소를 찾습니다.
    blackbox_year = '2025'
    blackbox_year_button_xpath = f"//div[@class='inp-select-list']/ul[@name='selPurDate']/li/button[text()='{blackbox_year}']"

    # blackbox_year_button = WebDriverWait(driver, 10).until(
    #     EC.element_to_be_clickable((By.XPATH, blackbox_year_button_xpath))
    # )
    # blackbox_year_button.click()
    common.find(driver, blackbox_year_button_xpath).click()
    common.find(driver, '//*[@id="amt_black_box"]').send_keys("13")
    common.find(driver, '//*[@id="blackboxPopupOKBtn"]').click()
    common.find(driver, '//*[@id="btnNext2"]').click()

    #############
    # 다음 페이지 #
    #############

    # Todo: 운전자 정보 선택 기능 필요 (현재는 본인 1인 고정으로 진행)

    next_button = common.waitTimeOut(driver, '//*[@id="btnNext"]', "load")
    next_button.click()

    print("운전자 정보 선택 완료")



    #############
    # 다음 페이지 #
    #############

    alert_ok_button = common.waitTimeOut(driver, '//*[@id="msgPushLayer0"]/div/div/div[3]/div/button', "click")
    print("알럿창 클릭")
    alert_ok_button.click()

    # 주행거리할인특약 = 'Y'
    # if 주행거리할인특약 != 'Y':
    #     distance_discount_button = WebDriverWait(driver, 10).until(
    #         EC.element_to_be_clickable((By.XPATH, '//*[@id="sp_distance"]/label'))
    #     )
    #     distance_discount_button.click()
    #
    #     cancel_button = WebDriverWait(driver, 10).until(
    #         EC.element_to_be_clickable((By.XPATH, '//*[@id="cmConfirmCancel"]'))
    #     )
    #     cancel_button.click()
    # print("주행거리할인특약 설정 완료")

    # Todo: Baby in Car 할인특약 기능 추가 필요 (현재는 미가입으로 진행)

    next_button = common.waitTimeOut(driver, '//*[@id="content"]/div/section/div/div[3]/div/button[2]', "click")
    next_button.click()
    print("다음 버튼 클릭")


    #############
    # 다음 페이지 #
    #############

    # Todo: 보험료 계산 페이지에서 담보 설정 기능 추가 필요 (현재는 전부 기본값으로 진행)

    amount_element = common.waitTimeOut(driver, "spanTopPrm", "load", "id")
    amount_text = amount_element.text
    print(f"추출된 금액 텍스트: {amount_text}")

    next_button = common.waitTimeOut(driver, '//*[@id="content"]/div/section/div/div[2]/div/button[2]', "click")
    next_button.click()

    # 추천담보로 변경 페이지가 뜰 경우 '기존 유지' 버튼 클릭
    try:
        button = common.waitTimeOut(driver, '//*[@id="atarcStep4RecHggCvrPop"]/div/div/div[3]/div/button[1]', "click")
        button.click()
    except TimeoutException:
        pass

    # driver.quit()
    # return amount_text