import os
from dotenv import load_dotenv

load_dotenv()  # Load environment variables from .env

class Config:
    SECRET_KEY = os.getenv("SECRET_KEY")
    SQLALCHEMY_DATABASE_URI = os.getenv("DATABASE_URL", "postgresql://postgres.gldbjvxwlxxykaqwyeiq:7518815@aws-0-eu-central-1.pooler.supabase.com:5432/postgres")
    # SQLALCHEMY_TRACK_MODIFICATIONS = False
