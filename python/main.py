# 환경변수 설정
from config import Config
from fastapi import FastAPI
from services.directdb import directdb
from services.meritz import meritz
from services.kb import kb
from services.hyundai import hyundai
from services.samsung import samsung

app = FastAPI(docs_url=None, redoc_url=None, openapi_url=None)
cfg = Config()
@app.get("/")
def index():

    return {"message": cfg.api_url}

@app.get("/directdb/{user_idx}")
def runDirectdb(user_idx: int):
    cfg.getApiData(user_idx)
    cfg.api_data["type"] = "db"
    result = directdb(cfg)
    return {"result": result}

@app.get("/meritz/{user_idx}")
def runMeritz(user_idx: int):
    cfg.getApiData(user_idx)
    result = meritz(cfg)
    return {"result": result}

@app.get("/kb/{user_idx}")
def runKb(user_idx: int):
    cfg.getApiData(user_idx)
    result = kb(cfg)
    return {"result": result}

@app.get("/hyundai/{user_idx}")
def runHyundai(user_idx: int):
    cfg.getApiData(user_idx)
    result = hyundai(cfg)
    return {"result": result}

@app.get("/samsung/{user_idx}")
def runSamsung(user_idx: int):
    cfg.getApiData(user_idx)
    result = samsung(cfg)
    return {"result": result}