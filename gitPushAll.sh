#!/bin/bash
git add .;
echo "Add commit message:";
read message;
git commit -m "$message";
git push heroku master;
git push;
