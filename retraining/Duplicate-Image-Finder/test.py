import json

f = open('/Users/kyronling/Downloads/Duplicate-Image-Finder-main/difPy_stats_1677651077_4567869.json')
data = json.load(f)

for i in data['emp_details']:
    print(i)
  
# Closing file
f.close()