eval 'java -jar selenium.jar' |
while IFS= read -r i
do
  echo $i
  if [[$i = "Selenium Server is up and running on port 4444"]]
  then
    echo "Server started"
    exit 1
  fi
done