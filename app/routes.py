from flask import Blueprint, render_template
from app.models.models import HomeContent, AboutMe, Service, PortfolioItem, BlogPost

main = Blueprint("main", __name__)

@main.route("/")
def home():
    content = HomeContent.query.first()
    return render_template("home.html", content=content)

@main.route("/about")
def about():
    about_me = AboutMe.query.first()
    return render_template("about.html", about_me=about_me)

@main.route("/services")
def services():
    services = Service.query.all()
    return render_template("services.html", services=services)

@main.route("/portfolio")
def portfolio():
    projects = PortfolioItem.query.all()
    return render_template("portfolio.html", projects=projects)

@main.route("/blog")
def blog():
    posts = BlogPost.query.order_by(BlogPost.created_at.desc()).all()
    return render_template("blog.html", posts=posts)

@main.route("/contact")
def contact():
    return render_template("contact.html")
