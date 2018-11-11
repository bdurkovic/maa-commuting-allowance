# maa-commuting-allowance
Commuting allowance calculator calculates the amount for the commuting allowance employees of a company get.

### Installation

Simply pull `https://github.com/bdurkovic/maa-commuting-allowance.git` to the desired location and run `composer install`.

### Usage

By running `public/index.php` output file will be generated.

The configuration file is in the repository, and looks like this:

```
[compensation_per_km]
Bike = 0.5
Bus = 0.25
Train = 0.25
Car = 0.1

[encouraged_distance]
begin = 5
end = 10
multiplier = 2

[output_file]
name = commuting_allowance_2018
```

The section `compensation_per_km` contains, per transportation method and per kilometer of distance, the amount of euros that will be compensated.

The section `encouraged_distance` provides a specially encouraged distance range, and the multiplier for the compensation amount.

The section `output_file` contains the output file name.