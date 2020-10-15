#!/bin/bash
git add .;
read message;
echo "add commit message:";
git commit -m "$message";
git push heroku master;
