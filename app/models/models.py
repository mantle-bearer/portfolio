from flask_sqlalchemy import SQLAlchemy
from sqlalchemy import Column, Integer, String, Text, ForeignKey, DateTime
from sqlalchemy.orm import relationship
from datetime import datetime
from pydantic import BaseModel

db = SQLAlchemy()

class BaseModel(db.Model):
    """Base model with common fields."""
    __abstract__ = True
    id = Column(Integer, primary_key=True)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, onupdate=datetime.utcnow)


class AdminUser(BaseModel):
    """Admin user model for authentication."""
    __tablename__ = "admin_users"
    
    username = Column(String(50), unique=True, nullable=False)
    password_hash = Column(String(255), nullable=False)


class HomeContent(BaseModel):
    """Stores homepage content."""
    __tablename__ = "home_content"

    title = Column(String(255), nullable=False)
    subtitle = Column(String(255), nullable=True)
    cv_url = Column(String(500), nullable=True)


class AboutMe(BaseModel):
    """Stores about me page content."""
    __tablename__ = "about_me"

    description = Column(Text, nullable=False)
    experience_years = Column(Integer, default=0)
    clients = Column(Integer, default=0)
    working_hours = Column(Integer, default=0)
    awards = Column(Integer, default=0)


class Service(BaseModel):
    """Services offered."""
    __tablename__ = "services"

    title = Column(String(100), nullable=False)
    description = Column(Text, nullable=True)
    icon = Column(String(100), nullable=True)  # FontAwesome class or image path


class PortfolioItem(BaseModel):
    """Portfolio projects."""
    __tablename__ = "portfolio"

    title = Column(String(255), nullable=False)
    image_url = Column(String(500), nullable=False)
    description = Column(Text, nullable=True)


class BlogPost(BaseModel):
    """Blog posts."""
    __tablename__ = "blog_posts"

    title = Column(String(255), nullable=False)
    content = Column(Text, nullable=False)
    image_url = Column(String(500), nullable=True)
    created_at = Column(DateTime, default=datetime.utcnow)


class ContactMessage(BaseModel):
    """Messages submitted via contact form."""
    __tablename__ = "contact_messages"

    name = Column(String(255), nullable=False)
    email = Column(String(255), nullable=False)
    subject = Column(String(255), nullable=True)
    message = Column(Text, nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
