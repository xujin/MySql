#!/bin/bash
echo "# MySql" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin git@github.com:xujin/MySql.git
git push -u origin master
