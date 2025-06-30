import requests

class Config:
    def __init__(self):
        self.user_idx = None
        self.api_url = "http://192.168.0.200:82/api/getData"
        self.api_number_url = "http://192.168.0.200:82/api/getAuthNumber"
        self.directdb_url = "https://www.directdb.co.kr/at/prd/atarc/step1/formStepPreView.do"
        self.meritz_url = "https://store.meritzfire.com/auto-and-driver/direct-auto.do#!/contractPopup"
        self.kb_url = "https://direct.kbinsure.co.kr/home/#/WS/IS/COMN_4012M/?pid=1090041&code=0251&joinMall=Y&utm_source=Google&utm_medium=google%20CPC(%EC%9D%BC%EB%B0%98_%EB%B8%8C%EB%9E%9C%EB%93%9CKW)&utm_term=KB%EB%8B%A4%EC%9D%B4%EB%A0%89%ED%8A%B8%EC%9E%90%EB%8F%99%EC%B0%A8%EB%B3%B4%ED%97%98&utm_campaign=0706_1231_google_sa&utm_content=10900410251&gclid=CjwKCAjwgb_CBhBMEiwA0p3oOImJDw4bYFFUsaAdf7LwYvS_gpkJGEsw4YiejIMdkQ8sFAELRE9ayxoCstMQAvD_BwE"
        self.hyundai_url = "https://mdirect.hi.co.kr/service.do?m=b5eef5f9a4"
        # self.directdb_url = "https://www.naver.com"

    def getApiData(self, user_idx: int):
        try:
            self.user_idx = user_idx
            datas = {"user_idx": user_idx}
            response = requests.post(self.api_url, data=datas)
            # 예외 처리
            response.raise_for_status()

            # 응답을 JSON으로 파싱
            api_data = response.json()
            if api_data["status"] == "success":
                self.api_data = api_data["data"]
            else:
                self.api_data = None
        except requests.RequestException as e:
            print("API 요청 실패:", e)
            self.api_data = None
        return