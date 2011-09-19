New Tournament System (NTS)
===========================


NTS is my first project where I use Nette2 beta. I decided to return back to Nette Framework after one year of experiencing OOP in C++. Though I still have to ask the community to respond my dummy questions, I keep trying not to give up because I like the framework concept and its ideas.


In the future I would like to implement following:
  #visitors
    - can view running/scheduled/completed tournaments
    - can comment a match
    - can download replays
    - can view match reports
    - can register a new player account

  #players
    - can register to any scheduled tournament
    - can unregister from any scheduled tournament
    - can upload their replays
    - can contact their opponent via PM (notification system)
    - can add a friend into a team (=> 2v2, 3v3 etc tournaments)
    
  #tournament operators
    - can add/edit/delete tournaments
      - number of slots (players) is scalable (any power of 2)
      - support of both single and double elimination systems
    - can edit match results
    - can add maps into map pool
    - can add bad points (player doesn't show up for a match etc.)
    
  #site administrator
    - can un/ban users
    - can demote/promote users (e.g. a player to an operator)
    - can update the global stats database


Created with
------------
Nette2.0-beta
dibi 1.5rc


