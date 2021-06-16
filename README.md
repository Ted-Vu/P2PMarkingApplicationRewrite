# P2PMarkingApplicationRewrite
Ted Vu 2021

© Ted Vu 2021. Disclaimer: This repo is an asset of Ted Vu.

## Developer

The original project was developed using Google Cloud and NoSQL by **Kevin Vu** and Ted Vu.

This ported version is written by **Ted Vu** using MySQL. 

## Project scenario

Classroom Student Software Demo is wonderful, but who should be the evaluator? Some argue it should be lecturer, but there are two inherent problems with this argument:

- To make the process of evaluation become fair, lecturer should come up with a set of criteria or rubric, however, this Demo Activity is not rigorous, its sole purpose is to allow student to engage more with hands-on programming experience and be employable. To make this activity interesting students should be allow to be creative and go wild with their imagination. Plus, it will be a burden on lecturer having to come up with rubric everytime a student wants to pitch his/her ideas since this activity is not mandatory in the course.
- On the other hand, not having a rubric can lead to biases in evaluation.

Ok how about students marking each other's work, that sounds like a great solution! Let's create a Peer-to-Peer Marking Application, the software will be subject to but not limited to these following requirements:

1. Student:

- Register their account.
- Change their name/password.
- Mark other team and not their own (fairness).
- Making only one evaluation ( fairness+security).

1. Network Admin/Lecturer:

- See the mark for demoed team.
- Reset Database for the next demo session.

