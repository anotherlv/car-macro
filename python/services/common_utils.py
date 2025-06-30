import time
import requests
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.ui import WebDriverWait

class CommonUtils:
    def waitTimeOut(self, driver, value, expected_type, key="xpath"):
        timeout = 10

        match expected_type:
            case "load":
                ec = expected_conditions.presence_of_element_located
            case "fade":
                ec = expected_conditions.invisibility_of_element_located
            case "visible":
                ec = expected_conditions.visibility_of_element_located
            case _:
                ec = expected_conditions.element_to_be_clickable

        match key:
            case "css":
                by_key = By.CSS_SELECTOR
            case "class":
                by_key = By.CLASS_NAME
            case "id":
                by_key = By.ID
            case _:
                by_key = By.XPATH

        return WebDriverWait(driver, timeout).until(ec((by_key, value)))

    def find(self, driver, value, key="xpath"):
        match key:
            case "css":
                by_key = By.CSS_SELECTOR
            case "class":
                by_key = By.CLASS_NAME
            case "id":
                by_key = By.ID
            case _:
                by_key = By.XPATH
        return driver.find_element(by_key, value)

    def setData(self, cfg):
        # match cfg.api_data["type"]:
        #     case "db":
        #         by_key = By.CSS_SELECTOR
        #     case "kb":
        #         by_key = By.CLASS_NAME
        #     case "samsung":
        #         by_key = By.ID
        #     case "hyundai":
        #         by_key = By.ID
        #     case "meritz":
        #         by_key = By.ID
        #     case _:
        #         by_key = By.XPATH
        ssn = cfg.api_data["ssn"]
        ssn_split = ssn.split("-")

        data = {
            "name" : cfg.api_data["name"],
            "rrno_1" : ssn_split[0],
            "rrno_2" : ssn_split[1],
            "phone_1" : cfg.api_data["phone"][:3],
            "phone_2" : cfg.api_data["phone"][3:],
            "telecom" : cfg.api_data["telecom"],
            "car_number" : cfg.api_data["car_num"],
            "blackbox_year" : cfg.api_data["blackbox_year"],
            "blackbox_price" : cfg.api_data["blackbox_price"],
        }

        return data

    def getAuthNumber(self, cfg, retry_cnt = 0, max_retry = 5):
        try:
            datas = {"user_idx": cfg.api_data["idx"], "type": cfg.api_data["type"]}
            response = requests.post(cfg.api_number_url, data=datas)
            # 예외 처리
            response.raise_for_status()

            # 응답을 JSON으로 파싱
            api_data = response.json()
            if api_data["status"] == "success":
                auth_number = api_data["result"]
            elif api_data["status"] == "wait":
                if retry_cnt < max_retry:
                    time.sleep(1)
                    return self.getAuthNumber(cfg, retry_cnt + 1, max_retry)
                else:
                    print("API 요청 실패: 최대 재시도 횟수 초과")
                    auth_number = None
            else:
                auth_number = None
        except requests.RequestException as e:
            print("API 요청 실패:", e)
            auth_number = None

        return auth_number
