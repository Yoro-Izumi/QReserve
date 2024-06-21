# find_peak_hour.py
import sys
import json
from datetime import datetime
from collections import Counter

try:
    # Read reservation times from input (passed from PHP)
    reservation_times = json.loads(sys.stdin.read())

    # Check if reservation_times is empty
    if not reservation_times:
        print(json.dumps([]))
        sys.exit(0)

    # Convert to datetime objects
    reservation_datetimes = [datetime.strptime(time, '%H:%M:%S') for time in reservation_times]

    # Extract the hours from the reservation times
    reservation_hours = [dt.hour for dt in reservation_datetimes]

    # Count the frequency of each hour
    hour_counts = Counter(reservation_hours)

    # Prepare data for the graph
    peak_times_data = [{"hour": hour, "count": count} for hour, count in hour_counts.items()]

    # Output the result to be used in PHP
    print(json.dumps(peak_times_data))
except Exception as e:
    print(json.dumps({"error": str(e)}))
    sys.exit(1)
